<?php

declare(strict_types=1);

namespace GacikDesign\Api\Services;

use GacikDesign\Api\Exceptions\LicenseException;
use PDO;
use Psr\Log\LoggerInterface;

/**
 * Core licensing business logic.
 */
class LicenseService {

	/** Re-verify against Envato API every 7 days. */
	private const ENVATO_RECHECK_DAYS = 7;

	public function __construct(
		private readonly PDO $pdo,
		private readonly ?EnvatoApiService $envato,
		private readonly LicenseKeyGenerator $keyGenerator,
		private readonly DomainNormalizer $normalizer,
		private readonly SignatureService $signature,
		private readonly LoggerInterface $logger
	) {
	}

	/**
	 * Find a product by slug.
	 *
	 * @return array|null Product row or null.
	 */
	public function findProduct(string $slug): ?array {
		$stmt = $this->pdo->prepare("SELECT * FROM products WHERE slug = :slug AND is_active = 1");
		$stmt->execute(['slug' => $slug]);
		$row = $stmt->fetch();

		return $row ?: null;
	}

	/**
	 * Activate a purchase code for a domain.
	 *
	 * @return array Activation result with site_token.
	 * @throws LicenseException On validation/limit errors.
	 */
	public function activate(array $product, string $purchase_code, string $raw_domain, array $meta = []): array {
		$this->validatePurchaseCodeFormat($purchase_code);

		$domain   = $this->normalizer->normalize($raw_domain);
		$is_local = $this->normalizer->isLocal($domain);

		// Find or create license.
		$license = $this->findOrCreateLicense($product, $purchase_code);

		if ($license['is_blocked']) {
			throw LicenseException::blocked($license['block_reason'] ?? 'License has been blocked.');
		}

		// Check if this domain is already activated for this license.
		$existing = $this->findActivation($license['id'], $domain);

		if ($existing && $existing['is_active']) {
			// Re-activation: update metadata and return existing token.
			$this->updateActivationMeta($existing['id'], $meta);

			$this->logger->info('Re-activation', ['license_id' => $license['id'], 'domain' => $domain]);

			return [
				'status'          => 'activated',
				'site_token'      => $existing['site_token'],
				'license_type'    => $license['license_type'],
				'supported_until' => $license['supported_until'],
				'is_reactivation' => true,
			];
		}

		// Check domain activation limit (local domains don't count).
		if (!$is_local) {
			$active_count = $this->countActiveProductionDomains($license['id']);
			$max_domains  = $license['license_type'] === 'extended'
				? $product['max_domains_extended']
				: $product['max_domains_regular'];

			if ($active_count >= $max_domains) {
				$active_domains = $this->getActiveProductionDomains($license['id']);
				throw LicenseException::activationLimit($max_domains, $active_domains);
			}
		}

		// Create new activation.
		$site_token = $this->signature->generateSiteToken();

		$stmt = $this->pdo->prepare("
			INSERT INTO activations (license_id, domain, site_token, ip_address, wp_version, theme_version, php_version, is_local)
			VALUES (:license_id, :domain, :site_token, :ip, :wp, :theme, :php, :is_local)
			ON DUPLICATE KEY UPDATE
				site_token = VALUES(site_token),
				is_active = 1,
				deactivated_at = NULL,
				activated_at = NOW(),
				last_verified_at = NOW(),
				ip_address = VALUES(ip_address),
				wp_version = VALUES(wp_version),
				theme_version = VALUES(theme_version),
				php_version = VALUES(php_version)
		");
		$stmt->execute([
			'license_id' => $license['id'],
			'domain'     => $domain,
			'site_token' => $site_token,
			'ip'         => $meta['ip_address'] ?? null,
			'wp'         => $meta['wp_version'] ?? null,
			'theme'      => $meta['theme_version'] ?? null,
			'php'        => $meta['php_version'] ?? null,
			'is_local'   => $is_local ? 1 : 0,
		]);

		$this->logger->info('New activation', [
			'license_id' => $license['id'],
			'domain'     => $domain,
			'is_local'   => $is_local,
		]);

		return [
			'status'          => 'activated',
			'site_token'      => $site_token,
			'license_type'    => $license['license_type'],
			'supported_until' => $license['supported_until'],
			'is_reactivation' => false,
		];
	}

	/**
	 * Deactivate a license for a domain.
	 */
	public function deactivate(string $purchase_code, string $raw_domain): bool {
		$domain = $this->normalizer->normalize($raw_domain);

		$stmt = $this->pdo->prepare("
			UPDATE activations a
			JOIN licenses l ON a.license_id = l.id
			SET a.is_active = 0, a.deactivated_at = NOW()
			WHERE l.purchase_code = :code AND a.domain = :domain AND a.is_active = 1
		");
		$stmt->execute(['code' => $purchase_code, 'domain' => $domain]);

		$affected = $stmt->rowCount() > 0;

		if ($affected) {
			$this->logger->info('Deactivation', ['purchase_code' => $this->censorCode($purchase_code), 'domain' => $domain]);
		}

		return $affected;
	}

	/**
	 * Verify an existing activation.
	 *
	 * @return array Verification result.
	 * @throws LicenseException If activation not found or blocked.
	 */
	public function verify(string $purchase_code, string $raw_domain): array {
		$domain = $this->normalizer->normalize($raw_domain);

		$stmt = $this->pdo->prepare("
			SELECT a.*, l.is_blocked, l.license_type, l.supported_until, l.last_envato_check, l.source,
			       p.latest_version, p.slug as product_slug
			FROM activations a
			JOIN licenses l ON a.license_id = l.id
			JOIN products p ON l.product_id = p.id
			WHERE l.purchase_code = :code AND a.domain = :domain
		");
		$stmt->execute(['code' => $purchase_code, 'domain' => $domain]);
		$row = $stmt->fetch();

		if (!$row) {
			throw LicenseException::notActivated();
		}

		if (!$row['is_active']) {
			throw LicenseException::deactivated();
		}

		if ($row['is_blocked']) {
			// Auto-deactivate locally.
			$this->deactivate($purchase_code, $raw_domain);
			throw LicenseException::blocked('License has been revoked.');
		}

		// Periodic Envato re-check (only for Envato-sourced licenses).
		if (($row['source'] ?? 'envato') === 'envato') {
			$this->periodicEnvatoRecheck($row);
		}

		// Update last_verified_at.
		$update = $this->pdo->prepare("UPDATE activations SET last_verified_at = NOW() WHERE id = :id");
		$update->execute(['id' => $row['id']]);

		return [
			'status'          => 'active',
			'license_type'    => $row['license_type'],
			'supported_until' => $row['supported_until'],
			'latest_version'  => $row['latest_version'],
		];
	}

	/**
	 * Find an activation by site_token (used by signature middleware).
	 */
	public function findActivationByToken(string $site_token): ?array {
		$stmt = $this->pdo->prepare("
			SELECT a.*, l.purchase_code, l.is_blocked, p.slug as product_slug
			FROM activations a
			JOIN licenses l ON a.license_id = l.id
			JOIN products p ON l.product_id = p.id
			WHERE a.site_token = :token AND a.is_active = 1
		");
		$stmt->execute(['token' => $site_token]);
		$row = $stmt->fetch();

		return $row ?: null;
	}

	/**
	 * Log a download event.
	 */
	public function logDownload(int $activation_id, string $type, string $slug, ?int $file_size, ?string $ip): void {
		$stmt = $this->pdo->prepare("
			INSERT INTO download_logs (activation_id, resource_type, resource_slug, file_size, ip_address)
			VALUES (:aid, :type, :slug, :size, :ip)
		");
		$stmt->execute([
			'aid'  => $activation_id,
			'type' => $type,
			'slug' => $slug,
			'size' => $file_size,
			'ip'   => $ip,
		]);
	}

	/**
	 * Create a manual (GacikDesign-native) license.
	 *
	 * @return array The created license row including the full purchase_code.
	 */
	public function createManualLicense(array $product, string $license_type, ?string $buyer_username, ?string $buyer_email, ?string $supported_until): array {
		$purchase_code = $this->keyGenerator->generate();

		$stmt = $this->pdo->prepare("
			INSERT INTO licenses (product_id, purchase_code, source, buyer_username, buyer_email, license_type, supported_until)
			VALUES (:product_id, :code, 'manual', :buyer, :email, :license_type, :supported)
		");
		$stmt->execute([
			'product_id'   => $product['id'],
			'code'         => $purchase_code,
			'buyer'        => $buyer_username,
			'email'        => $buyer_email,
			'license_type' => $license_type,
			'supported'    => $supported_until,
		]);

		$id = (int) $this->pdo->lastInsertId();

		$this->logger->info('Manual license created', [
			'id'            => $id,
			'purchase_code' => $this->censorCode($purchase_code),
			'product'       => $product['slug'],
			'license_type'  => $license_type,
		]);

		return $this->findLicenseById($id);
	}

	// -------------------------------------------------------------------------
	// Private helpers.
	// -------------------------------------------------------------------------

	/**
	 * Find or create a license record, verifying via Envato API if needed.
	 */
	private function findOrCreateLicense(array $product, string $purchase_code): array {
		$stmt = $this->pdo->prepare("SELECT * FROM licenses WHERE purchase_code = :code");
		$stmt->execute(['code' => $purchase_code]);
		$license = $stmt->fetch();

		if ($license) {
			// Verify it belongs to the correct product.
			if ((int) $license['product_id'] !== (int) $product['id']) {
				throw LicenseException::wrongProduct($product['name']);
			}

			return $license;
		}

		// New code not in DB — route based on format.
		if ($this->keyGenerator->isGacikKey($purchase_code)) {
			// GD- keys must be pre-created by admin; they cannot self-register.
			throw LicenseException::keyNotFound();
		}

		// Envato UUID — verify against Envato API.
		if ($this->envato === null) {
			throw LicenseException::envatoUnavailable();
		}

		$result = $this->envato->verifySale($purchase_code);

		if (!$result['valid']) {
			throw LicenseException::invalidCode($result['data']['message'] ?? 'Invalid purchase code.');
		}

		// Check that item_id matches this product.
		if ($product['envato_item_id'] !== null && (int) $result['data']['item_id'] !== (int) $product['envato_item_id']) {
			throw LicenseException::wrongProduct($product['name']);
		}

		$license_type = $this->envato->parseLicenseType($result['data']['license'] ?? '');

		$stmt = $this->pdo->prepare("
			INSERT INTO licenses (product_id, purchase_code, source, buyer_username, buyer_email, license_type, supported_until, envato_raw_response, last_envato_check)
			VALUES (:product_id, :code, 'envato', :buyer, :email, :license_type, :supported, :raw, NOW())
		");
		$stmt->execute([
			'product_id'   => $product['id'],
			'code'         => $purchase_code,
			'buyer'        => $result['data']['buyer'] ?? null,
			'email'        => null, // Envato API doesn't expose buyer email.
			'license_type' => $license_type,
			'supported'    => $result['data']['supported_until'] ?? null,
			'raw'          => json_encode($result['data']['raw_response']),
		]);

		$id = (int) $this->pdo->lastInsertId();

		$this->logger->info('New license created via Envato', [
			'id'            => $id,
			'purchase_code' => $this->censorCode($purchase_code),
			'product'       => $product['slug'],
			'license_type'  => $license_type,
		]);

		return $this->findLicenseById($id);
	}

	private function findLicenseById(int $id): array {
		$stmt = $this->pdo->prepare("SELECT * FROM licenses WHERE id = :id");
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	private function findActivation(int $license_id, string $domain): ?array {
		$stmt = $this->pdo->prepare("SELECT * FROM activations WHERE license_id = :lid AND domain = :domain");
		$stmt->execute(['lid' => $license_id, 'domain' => $domain]);
		$row = $stmt->fetch();

		return $row ?: null;
	}

	private function updateActivationMeta(int $activation_id, array $meta): void {
		$stmt = $this->pdo->prepare("
			UPDATE activations
			SET last_verified_at = NOW(),
			    wp_version = COALESCE(:wp, wp_version),
			    theme_version = COALESCE(:theme, theme_version),
			    php_version = COALESCE(:php, php_version),
			    ip_address = COALESCE(:ip, ip_address)
			WHERE id = :id
		");
		$stmt->execute([
			'id'    => $activation_id,
			'wp'    => $meta['wp_version'] ?? null,
			'theme' => $meta['theme_version'] ?? null,
			'php'   => $meta['php_version'] ?? null,
			'ip'    => $meta['ip_address'] ?? null,
		]);
	}

	private function countActiveProductionDomains(int $license_id): int {
		$stmt = $this->pdo->prepare("
			SELECT COUNT(*) FROM activations
			WHERE license_id = :lid AND is_active = 1 AND is_local = 0
		");
		$stmt->execute(['lid' => $license_id]);

		return (int) $stmt->fetchColumn();
	}

	private function getActiveProductionDomains(int $license_id): array {
		$stmt = $this->pdo->prepare("
			SELECT domain FROM activations
			WHERE license_id = :lid AND is_active = 1 AND is_local = 0
		");
		$stmt->execute(['lid' => $license_id]);

		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}

	/**
	 * Re-check with Envato API if enough time has passed.
	 * Only called for Envato-sourced licenses.
	 */
	private function periodicEnvatoRecheck(array $row): void {
		// Skip if Envato service is not configured.
		if ($this->envato === null) {
			return;
		}

		if (empty($row['last_envato_check'])) {
			return;
		}

		$last_check = strtotime($row['last_envato_check']);
		$threshold  = time() - (self::ENVATO_RECHECK_DAYS * 86400);

		if ($last_check > $threshold) {
			return; // Not due yet.
		}

		// Get the purchase code for re-verification.
		$stmt = $this->pdo->prepare("SELECT purchase_code, id FROM licenses WHERE id = (
			SELECT license_id FROM activations WHERE id = :aid
		)");
		$stmt->execute(['aid' => $row['id']]);
		$license = $stmt->fetch();

		if (!$license) {
			return;
		}

		$result = $this->envato->verifySale($license['purchase_code']);

		// Update last check timestamp regardless of result.
		$update = $this->pdo->prepare("UPDATE licenses SET last_envato_check = NOW() WHERE id = :id");
		$update->execute(['id' => $license['id']]);

		if (!$result['valid'] && ($result['data']['error'] ?? '') === 'invalid_code') {
			// Code was refunded/chargedback — block it.
			$block = $this->pdo->prepare("
				UPDATE licenses SET is_blocked = 1, block_reason = 'Envato verification failed (refund/chargeback)'
				WHERE id = :id
			");
			$block->execute(['id' => $license['id']]);

			$this->logger->warning('License auto-blocked after Envato re-check', [
				'license_id' => $license['id'],
			]);
		}
	}

	private function validatePurchaseCodeFormat(string $code): void {
		if (!$this->keyGenerator->isValidFormat($code)) {
			throw LicenseException::invalidFormat();
		}
	}

	private function censorCode(string $code): string {
		if (strlen($code) < 12) {
			return '****';
		}
		return substr($code, 0, 4) . '****' . substr($code, -4);
	}
}
