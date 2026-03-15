<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use GacikDesign\Api\Services\LicenseService;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminController {

	public function __construct(
		private readonly PDO $pdo,
		private readonly LicenseService $licenseService
	) {
	}

	/**
	 * GET /api/v1/admin/products
	 */
	public function listProducts(Request $request, Response $response): Response {
		$stmt     = $this->pdo->query("SELECT * FROM products ORDER BY name ASC");
		$products = $stmt->fetchAll();

		return $this->json($response, ['products' => $products]);
	}

	/**
	 * POST /api/v1/admin/products
	 */
	public function upsertProduct(Request $request, Response $response): Response {
		$body = $request->getParsedBody();

		$required = ['slug', 'name'];
		foreach ($required as $field) {
			if (empty($body[$field])) {
				return $this->json($response, ['error' => "Missing required field: {$field}"], 400);
			}
		}

		$stmt = $this->pdo->prepare("
			INSERT INTO products (slug, name, envato_item_id, latest_version, max_domains_regular, max_domains_extended)
			VALUES (:slug, :name, :item_id, :version, :max_regular, :max_extended)
			ON DUPLICATE KEY UPDATE
				name = VALUES(name),
				envato_item_id = VALUES(envato_item_id),
				latest_version = VALUES(latest_version),
				max_domains_regular = VALUES(max_domains_regular),
				max_domains_extended = VALUES(max_domains_extended)
		");
		$stmt->execute([
			'slug'         => $body['slug'],
			'name'         => $body['name'],
			'item_id'      => isset($body['envato_item_id']) ? (int) $body['envato_item_id'] : null,
			'version'      => $body['latest_version'] ?? '1.0.0',
			'max_regular'  => (int) ($body['max_domains_regular'] ?? 1),
			'max_extended' => (int) ($body['max_domains_extended'] ?? 5),
		]);

		return $this->json($response, ['status' => 'ok', 'slug' => $body['slug']]);
	}

	/**
	 * GET /api/v1/admin/licenses
	 */
	public function listLicenses(Request $request, Response $response): Response {
		$params  = $request->getQueryParams();
		$product = $params['product'] ?? null;
		$source  = $params['source'] ?? null;
		$page    = max(1, (int) ($params['page'] ?? 1));
		$limit   = min(100, max(1, (int) ($params['limit'] ?? 50)));
		$offset  = ($page - 1) * $limit;

		$where  = [];
		$binds  = [];

		if ($product) {
			$where[]          = 'p.slug = :product';
			$binds['product'] = $product;
		}

		if ($source) {
			$where[]         = 'l.source = :source';
			$binds['source'] = $source;
		}

		$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

		$count_sql = "SELECT COUNT(*) FROM licenses l JOIN products p ON l.product_id = p.id {$where_sql}";
		$count_stmt = $this->pdo->prepare($count_sql);
		$count_stmt->execute($binds);
		$total = (int) $count_stmt->fetchColumn();

		$sql = "
			SELECT l.id, l.purchase_code, l.source, l.buyer_username, l.buyer_email, l.license_type,
			       l.supported_until, l.is_blocked, l.block_reason, l.created_at,
			       p.slug as product,
			       (SELECT COUNT(*) FROM activations a WHERE a.license_id = l.id AND a.is_active = 1) as active_domains
			FROM licenses l
			JOIN products p ON l.product_id = p.id
			{$where_sql}
			ORDER BY l.created_at DESC
			LIMIT {$limit} OFFSET {$offset}
		";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($binds);
		$licenses = $stmt->fetchAll();

		// Censor purchase codes in listing.
		foreach ($licenses as &$lic) {
			$code = $lic['purchase_code'];
			$lic['purchase_code'] = substr($code, 0, 8) . '****' . substr($code, -4);
		}

		return $this->json($response, [
			'licenses' => $licenses,
			'total'    => $total,
			'page'     => $page,
			'pages'    => (int) ceil($total / $limit),
		]);
	}

	/**
	 * POST /api/v1/admin/licenses — Create a manual (GacikDesign-native) license.
	 */
	public function createLicense(Request $request, Response $response): Response {
		$body = $request->getParsedBody();

		if (empty($body['product_slug'])) {
			return $this->json($response, ['error' => 'Missing required field: product_slug'], 400);
		}

		$product = $this->licenseService->findProduct($body['product_slug']);
		if (!$product) {
			return $this->json($response, ['error' => 'Product not found.'], 404);
		}

		$license_type    = in_array($body['license_type'] ?? '', ['regular', 'extended'], true)
			? $body['license_type']
			: 'regular';
		$buyer_username  = $body['buyer_username'] ?? null;
		$buyer_email     = $body['buyer_email'] ?? null;
		$supported_until = $body['supported_until'] ?? null;

		$license = $this->licenseService->createManualLicense(
			$product,
			$license_type,
			$buyer_username,
			$buyer_email,
			$supported_until
		);

		return $this->json($response, [
			'status'          => 'created',
			'id'              => $license['id'],
			'purchase_code'   => $license['purchase_code'],
			'source'          => $license['source'],
			'license_type'    => $license['license_type'],
			'supported_until' => $license['supported_until'],
		], 201);
	}

	/**
	 * GET /api/v1/admin/licenses/{id} — Full license detail with uncensored code.
	 */
	public function getLicense(Request $request, Response $response, array $args): Response {
		$id = (int) ($args['id'] ?? 0);

		$stmt = $this->pdo->prepare("
			SELECT l.*, p.slug as product, p.name as product_name
			FROM licenses l
			JOIN products p ON l.product_id = p.id
			WHERE l.id = :id
		");
		$stmt->execute(['id' => $id]);
		$license = $stmt->fetch();

		if (!$license) {
			return $this->json($response, ['error' => 'License not found.'], 404);
		}

		// Get activations for this license.
		$act_stmt = $this->pdo->prepare("
			SELECT id, domain, ip_address, wp_version, theme_version, php_version,
			       is_local, is_active, activated_at, last_verified_at, deactivated_at
			FROM activations
			WHERE license_id = :lid
			ORDER BY activated_at DESC
		");
		$act_stmt->execute(['lid' => $license['id']]);
		$license['activations'] = $act_stmt->fetchAll();

		return $this->json($response, ['license' => $license]);
	}

	/**
	 * POST /api/v1/admin/licenses/{code}/block
	 */
	public function blockLicense(Request $request, Response $response, array $args): Response {
		$code = $args['code'] ?? '';
		$body = $request->getParsedBody();

		$stmt = $this->pdo->prepare("
			UPDATE licenses SET is_blocked = 1, block_reason = :reason WHERE purchase_code = :code
		");
		$stmt->execute([
			'code'   => $code,
			'reason' => $body['reason'] ?? 'Blocked by admin.',
		]);

		if ($stmt->rowCount() === 0) {
			return $this->json($response, ['error' => 'not_found', 'message' => 'License not found.'], 404);
		}

		return $this->json($response, ['status' => 'blocked', 'purchase_code' => $code]);
	}

	/**
	 * POST /api/v1/admin/licenses/{code}/unblock
	 */
	public function unblockLicense(Request $request, Response $response, array $args): Response {
		$code = $args['code'] ?? '';

		$stmt = $this->pdo->prepare("
			UPDATE licenses SET is_blocked = 0, block_reason = NULL WHERE purchase_code = :code
		");
		$stmt->execute(['code' => $code]);

		if ($stmt->rowCount() === 0) {
			return $this->json($response, ['error' => 'not_found', 'message' => 'License not found.'], 404);
		}

		return $this->json($response, ['status' => 'unblocked', 'purchase_code' => $code]);
	}

	/**
	 * GET /api/v1/admin/stats
	 */
	public function stats(Request $request, Response $response): Response {
		$stats = [];

		// Total licenses.
		$stats['total_licenses'] = (int) $this->pdo->query("SELECT COUNT(*) FROM licenses")->fetchColumn();

		// Active activations.
		$stats['active_activations'] = (int) $this->pdo->query("SELECT COUNT(*) FROM activations WHERE is_active = 1")->fetchColumn();

		// Blocked licenses.
		$stats['blocked_licenses'] = (int) $this->pdo->query("SELECT COUNT(*) FROM licenses WHERE is_blocked = 1")->fetchColumn();

		// Downloads last 30 days.
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM download_logs WHERE downloaded_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
		$stats['downloads_30d'] = (int) $stmt->fetchColumn();

		// Licenses by source.
		$stmt = $this->pdo->query("SELECT source, COUNT(*) as count FROM licenses GROUP BY source");
		$stats['licenses_by_source'] = $stmt->fetchAll();

		// Per-product breakdown.
		$stmt = $this->pdo->query("
			SELECT p.slug, p.name,
			       COUNT(DISTINCT l.id) as licenses,
			       COUNT(DISTINCT CASE WHEN a.is_active = 1 THEN a.id END) as active_domains
			FROM products p
			LEFT JOIN licenses l ON l.product_id = p.id
			LEFT JOIN activations a ON a.license_id = l.id
			GROUP BY p.id
			ORDER BY p.name
		");
		$stats['products'] = $stmt->fetchAll();

		return $this->json($response, $stats);
	}

	private function json(Response $response, array $data, int $status = 200): Response {
		$response->getBody()->write(json_encode($data));

		return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
	}
}
