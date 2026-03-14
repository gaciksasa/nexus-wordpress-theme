CREATE TABLE IF NOT EXISTS `download_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `activation_id` INT UNSIGNED NOT NULL,
    `resource_type` ENUM('demo', 'plugin', 'update') NOT NULL,
    `resource_slug` VARCHAR(100) NOT NULL,
    `file_size` BIGINT UNSIGNED DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `downloaded_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_activation_id` (`activation_id`),
    KEY `idx_downloaded_at` (`downloaded_at`),
    CONSTRAINT `fk_downloads_activation` FOREIGN KEY (`activation_id`) REFERENCES `activations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
