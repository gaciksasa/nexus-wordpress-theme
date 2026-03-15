<?php

declare(strict_types=1);

use GacikDesign\Api\Services\EnvatoApiService;
use GacikDesign\Api\Services\LicenseKeyGenerator;
use GacikDesign\Api\Services\LicenseService;
use GacikDesign\Api\Services\DomainNormalizer;
use GacikDesign\Api\Services\SignatureService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/database.php';

return [
	PDO::class => function () {
		return get_pdo();
	},

	LoggerInterface::class => function () {
		$logger = new Logger('gacikdesign-api');
		$logger->pushHandler(
			new StreamHandler(__DIR__ . '/../storage/logs/app.log', Logger::INFO)
		);
		return $logger;
	},

	EnvatoApiService::class => function () {
		$token = $_ENV['ENVATO_PERSONAL_TOKEN'] ?? '';
		if ($token === '') {
			return null;
		}
		return new EnvatoApiService($token);
	},

	LicenseKeyGenerator::class => function () {
		return new LicenseKeyGenerator();
	},

	DomainNormalizer::class => function () {
		return new DomainNormalizer();
	},

	SignatureService::class => function () {
		return new SignatureService($_ENV['APP_SECRET']);
	},

	LicenseService::class => function ($container) {
		return new LicenseService(
			$container->get(PDO::class),
			$container->get(EnvatoApiService::class),
			$container->get(LicenseKeyGenerator::class),
			$container->get(DomainNormalizer::class),
			$container->get(SignatureService::class),
			$container->get(LoggerInterface::class)
		);
	},
];
