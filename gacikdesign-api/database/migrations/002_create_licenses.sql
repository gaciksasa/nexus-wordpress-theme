CREATE TABLE IF NOT EXISTS `licenses` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `purchase_code` CHAR(36) NOT NULL,
    `buyer_username` VARCHAR(100) DEFAULT NULL,
    `buyer_email` VARCHAR(255) DEFAULT NULL,
    `license_type` ENUM('regular', 'extended') NOT NULL DEFAULT 'regular',
    `supported_until` DATETIME DEFAULT NULL,
    `envato_raw_response` JSON DEFAULT NULL,
    `is_blocked` TINYINT(1) NOT NULL DEFAULT 0,
    `block_reason` VARCHAR(255) DEFAULT NULL,
    `last_envato_check` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_purchase_code` (`purchase_code`),
    KEY `idx_product_id` (`product_id`),
    CONSTRAINT `fk_licenses_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
