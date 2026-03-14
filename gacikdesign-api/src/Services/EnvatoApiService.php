<?php

declare(strict_types=1);

namespace GacikDesign\Api\Services;

/**
 * Envato API integration for purchase code verification.
 *
 * Uses the Author Sale endpoint to verify purchase codes
 * and retrieve buyer information.
 */
class EnvatoApiService {

	private const API_BASE = 'https://api.envato.com/v3/market/author/sale';

	public function __construct(
		private readonly string $personal_token
	) {
	}

	/**
	 * Verify a purchase code against the Envato API.
	 *
	 * @param string $purchase_code The Envato purchase code (UUID).
	 * @return array{valid: bool, data: array}
	 */
	public function verifySale(string $purchase_code): array {
		$url = self::API_BASE . '?code=' . urlencode($purchase_code);

		$ch = curl_init($url);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTPHEADER     => [
				'Authorization: Bearer ' . $this->personal_token,
				'User-Agent: GacikDesign-License-API/1.0',
			],
		]);

		$response   = curl_exec($ch);
		$http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curl_error = curl_error($ch);
		curl_close($ch);

		if ($curl_error) {
			return [
				'valid' => false,
				'data'  => ['error' => 'curl_error', 'message' => $curl_error],
			];
		}

		if ($http_code === 404) {
			return [
				'valid' => false,
				'data'  => ['error' => 'invalid_code', 'message' => 'Purchase code not found or refunded.'],
			];
		}

		if ($http_code !== 200) {
			return [
				'valid' => false,
				'data'  => ['error' => 'api_error', 'message' => "Envato API returned HTTP {$http_code}"],
			];
		}

		$data = json_decode($response, true);

		if (!is_array($data) || !isset($data['item']['id'])) {
			return [
				'valid' => false,
				'data'  => ['error' => 'invalid_response', 'message' => 'Unexpected Envato API response format.'],
			];
		}

		return [
			'valid' => true,
			'data'  => [
				'item_id'         => (int) $data['item']['id'],
				'item_name'       => $data['item']['name'] ?? '',
				'buyer'           => $data['buyer'] ?? '',
				'license'         => $data['license'] ?? 'Regular License',
				'supported_until' => $data['supported_until'] ?? null,
				'amount'          => $data['amount'] ?? null,
				'sold_at'         => $data['sold_at'] ?? null,
				'raw_response'    => $data,
			],
		];
	}

	/**
	 * Determine license type from the Envato license string.
	 */
	public function parseLicenseType(string $license): string {
		$license = strtolower($license);

		if (str_contains($license, 'extended')) {
			return 'extended';
		}

		return 'regular';
	}
}
