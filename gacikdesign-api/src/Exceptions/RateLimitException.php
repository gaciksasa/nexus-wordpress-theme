<?php

declare(strict_types=1);

namespace GacikDesign\Api\Exceptions;

use RuntimeException;

class RateLimitException extends RuntimeException {

	public function __construct(int $retry_after = 60) {
		parent::__construct("Rate limit exceeded. Try again in {$retry_after} seconds.");
	}
}
