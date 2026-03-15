<?php

declare(strict_types=1);

use GacikDesign\Api\Controllers\LicenseController;
use GacikDesign\Api\Controllers\UpdateController;
use GacikDesign\Api\Controllers\DemoController;
use GacikDesign\Api\Controllers\PluginController;
use GacikDesign\Api\Controllers\AdminController;
use GacikDesign\Api\Middleware\RateLimitMiddleware;
use GacikDesign\Api\Middleware\SignatureMiddleware;
use GacikDesign\Api\Middleware\AdminAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

	// Product-scoped public/theme endpoints.
	$app->group('/api/v1/{product}', function (RouteCollectorProxy $group) {

		// License management.
		$group->post('/activate', [LicenseController::class, 'activate']);
		$group->post('/deactivate', [LicenseController::class, 'deactivate']);
		$group->post('/verify', [LicenseController::class, 'verify']);

		// Theme updates.
		$group->get('/check-update', [UpdateController::class, 'checkUpdate']);
		$group->get('/download-update', [UpdateController::class, 'downloadUpdate']);

		// Demo content.
		$group->get('/demos', [DemoController::class, 'list']);
		$group->get('/download-demo/{slug}', [DemoController::class, 'download']);

		// Bundled plugins.
		$group->get('/plugins', [PluginController::class, 'list']);
		$group->get('/download-plugin/{slug}', [PluginController::class, 'download']);

	})->add(RateLimitMiddleware::class)
	  ->add(SignatureMiddleware::class);

	// Admin endpoints (API key auth).
	$app->group('/api/v1/admin', function (RouteCollectorProxy $group) {

		$group->get('/products', [AdminController::class, 'listProducts']);
		$group->post('/products', [AdminController::class, 'upsertProduct']);
		$group->get('/licenses', [AdminController::class, 'listLicenses']);
		$group->post('/licenses', [AdminController::class, 'createLicense']);
		$group->get('/licenses/{id:\d+}', [AdminController::class, 'getLicense']);
		$group->post('/licenses/{code}/block', [AdminController::class, 'blockLicense']);
		$group->post('/licenses/{code}/unblock', [AdminController::class, 'unblockLicense']);
		$group->get('/stats', [AdminController::class, 'stats']);

	})->add(AdminAuthMiddleware::class);

};
