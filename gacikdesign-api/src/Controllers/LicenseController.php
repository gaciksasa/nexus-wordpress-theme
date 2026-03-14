<?php

declare(strict_types=1);

namespace GacikDesign\Api\Controllers;

use GacikDesign\Api\Exceptions\LicenseException;
use GacikDesign\Api\Services\LicenseService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LicenseController {

	public function __construct(
		private readonly LicenseService $licenseService
	) {
	}

	/**
	 * POST /api/v1/{product}/activate
	 */
	public function activate(Request $request, Response $response, array $args): Response {
		$product_slug = $args['product'] ?? '';
		$product      = $this->licenseService->findProduct($product_slug);

		if (!$product) {
			return $this->json($response, ['error' => 'product_not_found', 'message' => 'Product not found.'], 404);
		}

		$body = $request->getParsedBody();

		$purchase_code = $body['purchase_code'] ?? '';
		$domain        = $body['domain'] ?? '';

		if (empty($purchase_code) || empty($domain)) {
			return $this->json($response, ['error' => 'missing_fields', 'message' => 'purchase_code and domain are required.'], 400);
		}

		try {
			$result = $this->licenseService->activate($product, $purchase_code, $domain, [
				'ip_address'    => $this->getClientIp($request),
				'wp_version'    => $body['wp_version'] ?? null,
				'theme_version' => $body['theme_version'] ?? null,
				'php_version'   => $body['php_version'] ?? null,
			]);

			return $this->json($response, $result);
		} catch (LicenseException $e) {
			$data = array_merge(
				['error' => 'license_error', 'message' => $e->getMessage()],
				$e->getExtraData()
			);

			return $this->json($response, $data, $e->getHttpStatus());
		}
	}

	/**
	 * POST /api/v1/{product}/deactivate
	 */
	public function deactivate(Request $request, Response $response, array $args): Response {
		$body = $request->getParsedBody();

		$purchase_code = $body['purchase_code'] ?? '';
		$domain        = $body['domain'] ?? '';

		if (empty($purchase_code) || empty($domain)) {
			return $this->json($response, ['error' => 'missing_fields', 'message' => 'purchase_code and domain are required.'], 400);
		}

		$success = $this->licenseService->deactivate($purchase_code, $domain);

		if (!$success) {
			return $this->json($response, ['error' => 'not_found', 'message' => 'No active activation found.'], 404);
		}

		return $this->json($response, ['status' => 'deactivated']);
	}

	/**
	 * POST /api/v1/{product}/verify
	 */
	public function verify(Request $request, Response $response, array $args): Response {
		$body = $request->getParsedBody();

		$purchase_code = $body['purchase_code'] ?? '';
		$domain        = $body['domain'] ?? '';

		if (empty($purchase_code) || empty($domain)) {
			return $this->json($response, ['error' => 'missing_fields', 'message' => 'purchase_code and domain are required.'], 400);
		}

		try {
			$result = $this->licenseService->verify($purchase_code, $domain);

			return $this->json($response, $result);
		} catch (LicenseException $e) {
			return $this->json($response, ['error' => 'license_error', 'message' => $e->getMessage()], $e->getHttpStatus());
		}
	}

	private function json(Response $response, array $data, int $status = 200): Response {
		$response->getBody()->write(json_encode($data));

		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus($status);
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
