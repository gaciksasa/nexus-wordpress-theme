<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use GacikDesign\Api\Services\LicenseService;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DemoController {

	private const STORAGE_BASE = __DIR__ . '/../../storage';

	public function __construct(
		private readonly PDO $pdo,
		private readonly LicenseService $licenseService
	) {
	}

	/**
	 * GET /api/v1/{product}/demos
	 *
	 * Returns the list of available demos for this product.
	 * This endpoint is public (no license check for listing).
	 */
	public function list(Request $request, Response $response, array $args): Response {
		$product = $this->licenseService->findProduct($args['product'] ?? '');

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found'], 404);
		}

		$stmt = $this->pdo->prepare("
			SELECT slug, name, screenshot_url, preview_url, sort_order
			FROM demos
			WHERE product_id = :pid AND is_active = 1
			ORDER BY sort_order ASC, name ASC
		");
		$stmt->execute(['pid' => $product['id']]);
		$demos = $stmt->fetchAll();

		return $this->json($response, ['demos' => $demos]);
	}

	/**
	 * GET /api/v1/{product}/download-demo/{slug}
	 *
	 * Streams a demo content ZIP. Requires active license.
	 */
	public function download(Request $request, Response $response, array $args): Response {
		$product = $this->licenseService->findProduct($args['product'] ?? '');

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found'], 404);
		}

		$activation = $request->getAttribute('activation');
		if (!$activation) {
			return $this->json($response, ['error' => 'unauthorized', 'message' => 'Active license required.'], 401);
		}

		$slug = $args['slug'] ?? '';

		$stmt = $this->pdo->prepare("
			SELECT * FROM demos
			WHERE product_id = :pid AND slug = :slug AND is_active = 1
		");
		$stmt->execute(['pid' => $product['id'], 'slug' => $slug]);
		$demo = $stmt->fetch();

		if (!$demo) {
			return $this->json($response, ['error' => 'demo_not_found', 'message' => "Demo '{$slug}' not found."], 404);
		}

		$file_path = self::STORAGE_BASE . '/' . $product['slug'] . '/demos/' . $demo['file_path'];

		if (!file_exists($file_path)) {
			return $this->json($response, ['error' => 'file_not_found', 'message' => 'Demo file not available.'], 404);
		}

		// Log download.
		$this->licenseService->logDownload(
			(int) $activation['id'],
			'demo',
			$slug,
			filesize($file_path) ?: null,
			$this->getClientIp($request)
		);

		return $this->streamFile($response, $file_path, $slug . '.zip');
	}

	private function streamFile(Response $response, string $path, string $filename): Response {
		$stream = fopen($path, 'rb');

		$response = $response
			->withHeader('Content-Type', 'application/zip')
			->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\"")
			->withHeader('Content-Length', (string) filesize($path));

		$body = $response->getBody();
		while (!feof($stream)) {
			$body->write(fread($stream, 8192));
		}
		fclose($stream);

		return $response;
	}

	private function json(Response $response, array $data, int $status = 200): Response {
		$response->getBody()->write(json_encode($data));

		return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
	}

	private function getClientIp(Request $request): string {
		$server = $request->getServerParams();

		foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'] as $key) {
			if (!empty($server[$key])) {
				return explode(',', $server[$key])[0];
			}
		}

		return '0.0.0.0';
	}
}
