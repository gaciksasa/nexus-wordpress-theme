<?php

declare(strict_types=1);

/**
 * Database migration runner.
 *
 * Usage: php database/migrate.php
 */

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require __DIR__ . '/../config/database.php';

$pdo = get_pdo();

// Create migrations tracking table.
$pdo->exec("
    CREATE TABLE IF NOT EXISTS `migrations` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `filename` VARCHAR(255) NOT NULL,
        `executed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `idx_filename` (`filename`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

// Get already-executed migrations.
$stmt     = $pdo->query("SELECT filename FROM migrations ORDER BY id");
$executed = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Find and run pending migrations.
$migration_dir = __DIR__ . '/migrations';
$files         = glob($migration_dir . '/*.sql');
sort($files);

$count = 0;

foreach ($files as $file) {
	$filename = basename($file);

	if (in_array($filename, $executed, true)) {
		echo "SKIP: {$filename} (already executed)\n";
		continue;
	}

	$sql = file_get_contents($file);
	if (empty(trim($sql))) {
		echo "SKIP: {$filename} (empty)\n";
		continue;
	}

	try {
		$pdo->exec($sql);
		$insert = $pdo->prepare("INSERT INTO migrations (filename) VALUES (:filename)");
		$insert->execute(['filename' => $filename]);
		echo "  OK: {$filename}\n";
		++$count;
	} catch (PDOException $e) {
		echo "FAIL: {$filename} — {$e->getMessage()}\n";
		exit(1);
	}
}

echo "\nDone. {$count} migration(s) executed.\n";
