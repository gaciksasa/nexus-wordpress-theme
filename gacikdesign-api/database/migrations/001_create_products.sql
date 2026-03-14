CREATE TABLE IF NOT EXISTS `products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `envato_item_id` INT UNSIGNED NOT NULL,
    `latest_version` VARCHAR(20) NOT NULL DEFAULT '1.0.0',
    `latest_version_file` VARCHAR(255) DEFAULT NULL,
    `max_domains_regular` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `max_domains_extended` TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
