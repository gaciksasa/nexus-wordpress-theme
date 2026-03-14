<?php

declare(strict_types=1);

namespace GacikDesign\Api\Services;

/**
 * Normalizes domains for consistent storage and comparison.
 */
class DomainNormalizer {

	/**
	 * Patterns that identify local/staging environments.
	 */
	private const LOCAL_PATTERNS = [
		'/^localhost$/',
		'/^127\.0\.0\.1$/',
		'/^10\.\d+\.\d+\.\d+$/',
		'/^192\.168\.\d+\.\d+$/',
		'/\.local$/',
		'/\.test$/',
		'/\.dev$/',
		'/\.localhost$/',
		'/\.staging\./',
		'/^staging\./',
	];

	/**
	 * Normalize a domain string.
	 *
	 * Strips protocol, www, trailing slash, port number.
	 * Returns lowercase result.
	 */
	public function normalize(string $domain): string {
		// Strip protocol.
		$domain = preg_replace('#^https?://#i', '', $domain);

		// Strip www.
		$domain = preg_replace('#^www\.#i', '', $domain);

		// Strip path and query string.
		$domain = explode('/', $domain)[0];
		$domain = explode('?', $domain)[0];

		// Strip port.
		$domain = preg_replace('#:\d+$#', '', $domain);

		// Trim and lowercase.
		$domain = strtolower(trim($domain));

		return $domain;
	}

	/**
	 * Determine if a domain is a local/staging environment.
	 */
	public function isLocal(string $normalized_domain): bool {
		foreach (self::LOCAL_PATTERNS as $pattern) {
			if (preg_match($pattern, $normalized_domain)) {
				return true;
			}
		}

		return false;
	}
}
