<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminController {

	public function __construct(
		private readonly PDO $pdo
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

		$required = ['slug', 'name', 'envato_item_id'];
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
			'item_id'      => (int) $body['envato_item_id'],
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
		$page    = max(1, (int) ($params['page'] ?? 1));
		$limit   = min(100, max(1, (int) ($params['limit'] ?? 50)));
		$offset  = ($page - 1) * $limit;

		$where  = '';
		$binds  = [];

		if ($product) {
			$where          = 'WHERE p.slug = :product';
			$binds['product'] = $product;
		}

		$count_sql = "SELECT COUNT(*) FROM licenses l JOIN products p ON l.product_id = p.id {$where}";
		$count_stmt = $this->pdo->prepare($count_sql);
		$count_stmt->execute($binds);
		$total = (int) $count_stmt->fetchColumn();

		$sql = "
			SELECT l.id, l.purchase_code, l.buyer_username, l.license_type, l.supported_until,
			       l.is_blocked, l.block_reason, l.created_at, p.slug as product,
			       (SELECT COUNT(*) FROM activations a WHERE a.license_id = l.id AND a.is_active = 1) as active_domains
			FROM licenses l
			JOIN products p ON l.product_id = p.id
			{$where}
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
