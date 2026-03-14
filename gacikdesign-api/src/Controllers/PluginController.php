<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use GacikDesign\Api\Services\LicenseService;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PluginController {

	private const STORAGE_BASE = __DIR__ . '/../../storage';

	public function __construct(
		private readonly PDO $pdo,
		private readonly LicenseService $licenseService
	) {
	}

	/**
	 * GET /api/v1/{product}/plugins
	 */
	public function list(Request $request, Response $response, array $args): Response {
		$product = $this->licenseService->findProduct($args['product'] ?? '');

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found'], 404);
		}

		$stmt = $this->pdo->prepare("
			SELECT slug, name, version, is_required
			FROM bundled_plugins
			WHERE product_id = :pid
			ORDER BY is_required DESC, name ASC
		");
		$stmt->execute(['pid' => $product['id']]);
		$plugins = $stmt->fetchAll();

		return $this->json($response, ['plugins' => $plugins]);
	}

	/**
	 * GET /api/v1/{product}/download-plugin/{slug}
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
			SELECT * FROM bundled_plugins
			WHERE product_id = :pid AND slug = :slug
		");
		$stmt->execute(['pid' => $product['id'], 'slug' => $slug]);
		$plugin = $stmt->fetch();

		if (!$plugin) {
			return $this->json($response, ['error' => 'plugin_not_found'], 404);
		}

		$file_path = self::STORAGE_BASE . '/' . $product['slug'] . '/plugins/' . $plugin['file_path'];

		if (!file_exists($file_path)) {
			return $this->json($response, ['error' => 'file_not_found', 'message' => 'Plugin file not available.'], 404);
		}

		// Log download.
		$this->licenseService->logDownload(
			(int) $activation['id'],
			'plugin',
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
