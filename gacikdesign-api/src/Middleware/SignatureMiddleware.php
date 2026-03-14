<?php

declare(strict_types=1);

namespace GacikDesign\Api\Middleware;

use GacikDesign\Api\Services\LicenseService;
use GacikDesign\Api\Services\SignatureService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 * HMAC signature verification middleware.
 *
 * For the /activate endpoint, signature is computed using the purchase code as key.
 * For all other endpoints, signature uses the site_token returned on activation.
 */
class SignatureMiddleware implements MiddlewareInterface {

	public function __construct(
		private readonly SignatureService $signatureService,
		private readonly LicenseService $licenseService
	) {
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$path = $request->getUri()->getPath();

		// The /activate endpoint uses purchase code as signing key.
		if (str_ends_with($path, '/activate')) {
			return $this->handleActivateSignature($request, $handler);
		}

		// All other endpoints use site_token.
		return $this->handleTokenSignature($request, $handler);
	}

	private function handleActivateSignature(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$signature = $request->getHeaderLine('X-Gacik-Signature');
		$timestamp = $request->getHeaderLine('X-Gacik-Timestamp');

		if (empty($signature) || empty($timestamp)) {
			return $this->unauthorizedResponse('Missing signature headers.');
		}

		$body = (string) $request->getBody();
		$request->getBody()->rewind();

		// Parse purchase_code from the body.
		$data = json_decode($body, true);
		$code = $data['purchase_code'] ?? '';

		if (empty($code)) {
			return $this->unauthorizedResponse('Missing purchase code.');
		}

		if (!$this->signatureService->verifyActivation($signature, $timestamp, $body, $code)) {
			return $this->unauthorizedResponse('Invalid signature.');
		}

		return $handler->handle($request);
	}

	private function handleTokenSignature(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
		$signature  = $request->getHeaderLine('X-Gacik-Signature');
		$timestamp  = $request->getHeaderLine('X-Gacik-Timestamp');
		$site_token = $request->getHeaderLine('X-Gacik-Token');

		if (empty($signature) || empty($timestamp) || empty($site_token)) {
			return $this->unauthorizedResponse('Missing signature headers.');
		}

		// Verify site_token exists and is active.
		$activation = $this->licenseService->findActivationByToken($site_token);

		if (!$activation) {
			return $this->unauthorizedResponse('Invalid or inactive site token.');
		}

		$body = (string) $request->getBody();
		$request->getBody()->rewind();

		if (!$this->signatureService->verify($signature, $timestamp, $body, $site_token)) {
			return $this->unauthorizedResponse('Invalid signature.');
		}

		// Attach activation data to request for downstream controllers.
		$request = $request->withAttribute('activation', $activation);

		return $handler->handle($request);
	}

	private function unauthorizedResponse(string $message): ResponseInterface {
		$response = new Response(401);
		$response->getBody()->write(json_encode([
			'error'   => 'unauthorized',
			'message' => $message,
		]));

		return $response->withHeader('Content-Type', 'application/json');
	}
}
