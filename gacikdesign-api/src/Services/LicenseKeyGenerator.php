<?php

declare(strict_types=1);

namespace GacikDesign\Api\Services;

/**
 * Generates and identifies GacikDesign-native license keys.
 *
 * Format: GD-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx (GD- prefix + UUID v4).
 */
class LicenseKeyGenerator {

	private const PREFIX = 'GD-';

	private const ENVATO_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

	private const GACIK_PATTERN = '/^GD-[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';

	/**
	 * Generate a new GacikDesign license key.
	 */
	public function generate(): string {
		$bytes = random_bytes(16);

		// Set version 4 (random) bits.
		$bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
		$bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);

		$uuid = sprintf(
			'%s-%s-%s-%s-%s',
			bin2hex(substr($bytes, 0, 4)),
			bin2hex(substr($bytes, 4, 2)),
			bin2hex(substr($bytes, 6, 2)),
			bin2hex(substr($bytes, 8, 2)),
			bin2hex(substr($bytes, 10, 6))
		);

		return self::PREFIX . $uuid;
	}

	/**
	 * Check if a code is a GacikDesign-native key.
	 */
	public function isGacikKey(string $code): bool {
		return (bool) preg_match(self::GACIK_PATTERN, $code);
	}

	/**
	 * Check if a code is an Envato UUID.
	 */
	public function isEnvatoKey(string $code): bool {
		return (bool) preg_match(self::ENVATO_PATTERN, $code);
	}

	/**
	 * Check if a code matches any supported format.
	 */
	public function isValidFormat(string $code): bool {
		return $this->isGacikKey($code) || $this->isEnvatoKey($code);
	}
}
