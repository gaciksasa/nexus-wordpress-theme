<?php

declare(strict_types=1);

namespace GacikDesign\Api\Exceptions;

use RuntimeException;

/**
 * License-related exceptions with HTTP status codes.
 */
class LicenseException extends RuntimeException {

	private int $http_status;
	private array $extra_data;

	public function __construct(string $message, int $http_status = 400, array $extra_data = []) {
		parent::__construct($message);
		$this->http_status = $http_status;
		$this->extra_data  = $extra_data;
	}

	public function getHttpStatus(): int {
		return $this->http_status;
	}

	public function getExtraData(): array {
		return $this->extra_data;
	}

	public static function invalidFormat(): self {
		return new self('Invalid purchase code format.', 400);
	}

	public static function invalidCode(string $reason = ''): self {
		return new self($reason ?: 'Invalid purchase code.', 403);
	}

	public static function wrongProduct(string $product_name): self {
		return new self("This purchase code does not belong to {$product_name}.", 403);
	}

	public static function blocked(string $reason = ''): self {
		return new self($reason ?: 'License has been blocked.', 403);
	}

	public static function activationLimit(int $max, array $active_domains): self {
		return new self(
			"Activation limit reached. Maximum {$max} production domain(s) allowed.",
			403,
			['active_domains' => $active_domains, 'max_domains' => $max]
		);
	}

	public static function notActivated(): self {
		return new self('No activation found for this domain.', 404);
	}

	public static function deactivated(): self {
		return new self('This activation has been deactivated.', 403);
	}

	public static function productNotFound(): self {
		return new self('Product not found.', 404);
	}
}
