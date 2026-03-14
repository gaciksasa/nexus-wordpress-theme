<?php

declare(strict_types=1);

/**
 * Initial seed: creates admin API key and Nexus product entry.
 *
 * Usage: php database/seeds/seed_initial.php
 */

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

require __DIR__ . '/../../config/database.php';

$pdo = get_pdo();

// 1. Generate admin API key.
$raw_key  = bin2hex(random_bytes(32));
$key_hash = password_hash($raw_key, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("
    INSERT INTO api_keys (name, key_hash, permissions)
    VALUES (:name, :key_hash, :permissions)
");
$stmt->execute([
	'name'        => 'Primary Admin',
	'key_hash'    => $key_hash,
	'permissions' => json_encode(['read', 'write', 'admin']),
]);

echo "Admin API key created.\n";
echo "RAW KEY (save this, it cannot be recovered): {$raw_key}\n\n";

// 2. Insert Nexus product.
$stmt = $pdo->prepare("
    INSERT INTO products (slug, name, envato_item_id, latest_version, max_domains_regular, max_domains_extended)
    VALUES (:slug, :name, :envato_item_id, :latest_version, :max_domains_regular, :max_domains_extended)
    ON DUPLICATE KEY UPDATE name = VALUES(name)
");
$stmt->execute([
	'slug'                 => 'nexus',
	'name'                 => 'Nexus - Multipurpose WordPress Theme',
	'envato_item_id'       => 0, // Replace with actual ThemeForest item ID after submission.
	'latest_version'       => '1.0.0',
	'max_domains_regular'  => 1,
	'max_domains_extended' => 5,
]);

echo "Product 'nexus' seeded (update envato_item_id after ThemeForest submission).\n";
