<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'APP_SECRET']);

// Build DI container.
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $containerBuilder->build();

// Create Slim app with DI container.
$app = AppFactory::createFromContainer($container);

// Add body parsing middleware (JSON).
$app->addBodyParsingMiddleware();

// Add error middleware.
$app->addErrorMiddleware(
	(bool) ($_ENV['APP_DEBUG'] ?? false),
	true,
	true
);

// Register routes.
(require __DIR__ . '/../config/routes.php')($app);

$app->run();
