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
 * API key authentication for admin endpoints.
 *
 * Expects: Authorization: Bearer <api_key>
 */
class AdminAuthMiddleware implements MiddlewareInterface {

	public function __construct(
		private readonly PDO $pdo
	) {
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$auth_header = $request->getHeaderLine('Authorization');

		if (empty($auth_header) || !str_starts_with($auth_header, 'Bearer ')) {
			return $this->forbiddenResponse('Missing or invalid Authorization header.');
		}

		$api_key = substr($auth_header, 7);

		// Look up all API keys and verify against bcrypt hashes.
		$stmt = $this->pdo->query("SELECT id, key_hash, permissions FROM api_keys");
		$keys = $stmt->fetchAll();

		foreach ($keys as $key) {
			if (password_verify($api_key, $key['key_hash'])) {
				// Update last_used_at.
				$update = $this->pdo->prepare("UPDATE api_keys SET last_used_at = NOW() WHERE id = :id");
				$update->execute(['id' => $key['id']]);

				// Attach permissions to request.
				$request = $request->withAttribute('api_key_id', $key['id']);
				$request = $request->withAttribute('api_permissions', json_decode($key['permissions'] ?? '[]', true));

				return $handler->handle($request);
			}
		}

		return $this->forbiddenResponse('Invalid API key.');
	}

	private function forbiddenResponse(string $message): ResponseInterface {
		$response = new Response(403);
		$response->getBody()->write(json_encode([
			'error'   => 'forbidden',
			'message' => $message,
		]));

		return $response->withHeader('Content-Type', 'application/json');
	}
}
