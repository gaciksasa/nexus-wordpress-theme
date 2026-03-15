-- Add license source tracking and widen purchase_code for GD- prefixed keys.

ALTER TABLE `licenses`
    ADD COLUMN `source` ENUM('envato', 'manual') NOT NULL DEFAULT 'envato' AFTER `purchase_code`,
    MODIFY COLUMN `purchase_code` VARCHAR(48) NOT NULL;

ALTER TABLE `products`
    MODIFY COLUMN `envato_item_id` INT UNSIGNED DEFAULT NULL;
