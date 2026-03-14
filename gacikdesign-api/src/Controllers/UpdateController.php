<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use GacikDesign\Api\Services\LicenseService;
use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UpdateController {

	private const STORAGE_BASE = __DIR__ . '/../../storage';

	public function __construct(
		private readonly PDO $pdo,
		private readonly LicenseService $licenseService
	) {
	}

	/**
	 * GET /api/v1/{product}/check-update
	 */
	public function checkUpdate(Request $request, Response $response, array $args): Response {
		$product = $this->licenseService->findProduct($args['product'] ?? '');

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found'], 404);
		}

		$params          = $request->getQueryParams();
		$current_version = $params['current_version'] ?? '0.0.0';
		$has_update      = version_compare($product['latest_version'], $current_version, '>');

		return $this->json($response, [
			'latest_version' => $product['latest_version'],
			'has_update'     => $has_update,
			'download_url'   => $has_update ? "/api/v1/{$product['slug']}/download-update" : null,
		]);
	}

	/**
	 * GET /api/v1/{product}/download-update
	 */
	public function downloadUpdate(Request $request, Response $response, array $args): Response {
		$product = $this->licenseService->findProduct($args['product'] ?? '');

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found'], 404);
		}

		$activation = $request->getAttribute('activation');
		if (!$activation) {
			return $this->json($response, ['error' => 'unauthorized', 'message' => 'Active license required.'], 401);
		}

		$file_path = self::STORAGE_BASE . '/' . $product['slug'] . '/updates/' . $product['latest_version_file'];

		if (!$product['latest_version_file'] || !file_exists($file_path)) {
			return $this->json($response, ['error' => 'file_not_found', 'message' => 'Update file not available.'], 404);
		}

		// Log download.
		$this->licenseService->logDownload(
			(int) $activation['id'],
			'update',
			$product['slug'] . '-' . $product['latest_version'],
			filesize($file_path) ?: null,
			$this->getClientIp($request)
		);

		return $this->streamFile($response, $file_path, basename($file_path));
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
