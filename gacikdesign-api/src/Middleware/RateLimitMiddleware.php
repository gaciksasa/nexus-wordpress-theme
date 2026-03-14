<?php

declare(strict_types=1);

namespace GacikDesign\Api\Middleware;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 * Rate limiting middleware using the database.
 */
class RateLimitMiddleware implements MiddlewareInterface {

	/** Rate limits per endpoint pattern (requests per hour). */
	private const LIMITS = [
		'activate'   => 10,
		'deactivate' => 10,
		'verify'     => 60,
		'download'   => 20,
		'default'    => 30,
	];

	private const WINDOW_SECONDS = 3600; // 1 hour.

	public function __construct(
		private readonly PDO $pdo
	) {
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$ip       = $this->getClientIp($request);
		$endpoint = $this->getEndpointKey($request);
		$limit    = $this->getLimit($endpoint);

		// Clean old entries.
		$this->cleanup();

		// Count requests in current window.
		$window_start = date('Y-m-d H:i:s', time() - self::WINDOW_SECONDS);

		$stmt = $this->pdo->prepare("
			SELECT SUM(request_count) as total
			FROM rate_limits
			WHERE identifier = :ip AND endpoint = :endpoint AND window_start >= :window
		");
		$stmt->execute(['ip' => $ip, 'endpoint' => $endpoint, 'window' => $window_start]);
		$count = (int) ($stmt->fetchColumn() ?: 0);

		if ($count >= $limit) {
			$response = new Response(429);
			$response->getBody()->write(json_encode([
				'error'   => 'rate_limit_exceeded',
				'message' => "Too many requests. Limit: {$limit}/hour.",
			]));

			return $response->withHeader('Content-Type', 'application/json')
				->withHeader('Retry-After', '60');
		}

		// Record this request.
		$this->record($ip, $endpoint);

		return $handler->handle($request);
	}

	private function record(string $ip, string $endpoint): void {
		$current_minute = date('Y-m-d H:i:00');

		$stmt = $this->pdo->prepare("
			INSERT INTO rate_limits (identifier, endpoint, request_count, window_start)
			VALUES (:ip, :endpoint, 1, :window)
			ON DUPLICATE KEY UPDATE request_count = request_count + 1
		");
		$stmt->execute(['ip' => $ip, 'endpoint' => $endpoint, 'window' => $current_minute]);
	}

	private function cleanup(): void {
		// Only clean up occasionally (1% of requests).
		if (random_int(1, 100) > 1) {
			return;
		}

		$cutoff = date('Y-m-d H:i:s', time() - self::WINDOW_SECONDS * 2);
		$this->pdo->prepare("DELETE FROM rate_limits WHERE window_start < :cutoff")->execute(['cutoff' => $cutoff]);
	}

	private function getClientIp(ServerRequestInterface $request): string {
		$server = $request->getServerParams();

		// Check common proxy headers.
		foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'] as $key) {
			if (!empty($server[$key])) {
				// X-Forwarded-For can contain multiple IPs; take the first.
				return explode(',', $server[$key])[0];
			}
		}

		return '0.0.0.0';
	}

	private function getEndpointKey(ServerRequestInterface $request): string {
		$path = $request->getUri()->getPath();

		if (str_contains($path, '/activate')) {
			return 'activate';
		}
		if (str_contains($path, '/deactivate')) {
			return 'deactivate';
		}
		if (str_contains($path, '/verify')) {
			return 'verify';
		}
		if (str_contains($path, '/download')) {
			return 'download';
		}

		return 'default';
	}

	private function getLimit(string $endpoint): int {
		// Allow .env overrides.
		$env_key = 'RATE_LIMIT_' . strtoupper($endpoint);
		if (!empty($_ENV[$env_key])) {
			return (int) $_ENV[$env_key];
		}

		return self::LIMITS[$endpoint] ?? self::LIMITS['default'];
	}
}
