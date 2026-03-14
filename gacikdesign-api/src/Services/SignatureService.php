<?php

declare(strict_types=1);

namespace GacikDesign\Api\Services;

/**
 * HMAC-SHA256 signature generation and verification.
 */
class SignatureService {

	private const REPLAY_WINDOW = 300; // 5 minutes in seconds.

	public function __construct(
		private readonly string $app_secret
	) {
	}

	/**
	 * Generate a random site token for a new activation.
	 */
	public function generateSiteToken(): string {
		return bin2hex(random_bytes(32)); // 64-char hex string.
	}

	/**
	 * Verify an HMAC signature from the theme client.
	 *
	 * The theme signs: HMAC-SHA256(timestamp + "|" + request_body, site_token)
	 *
	 * @param string $signature  The X-Nexus-Signature header value.
	 * @param string $timestamp  The X-Nexus-Timestamp header value (Unix timestamp).
	 * @param string $body       The raw request body.
	 * @param string $site_token The site_token stored in the activations table.
	 */
	public function verify(string $signature, string $timestamp, string $body, string $site_token): bool {
		// Check replay window.
		$now = time();
		$ts  = (int) $timestamp;

		if (abs($now - $ts) > self::REPLAY_WINDOW) {
			return false;
		}

		// Compute expected signature.
		$payload  = $timestamp . '|' . $body;
		$expected = hash_hmac('sha256', $payload, $site_token);

		return hash_equals($expected, $signature);
	}

	/**
	 * Verify a signature for the initial activate request (no site_token yet).
	 *
	 * For the activate endpoint, the theme signs with the purchase code itself
	 * since no site_token exists yet.
	 */
	public function verifyActivation(string $signature, string $timestamp, string $body, string $purchase_code): bool {
		$now = time();
		$ts  = (int) $timestamp;

		if (abs($now - $ts) > self::REPLAY_WINDOW) {
			return false;
		}

		$payload  = $timestamp . '|' . $body;
		$expected = hash_hmac('sha256', $payload, $purchase_code);

		return hash_equals($expected, $signature);
	}
}
