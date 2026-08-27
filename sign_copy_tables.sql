-- Create sign_copy_types table
CREATE TABLE `sign_copy_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_bn` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 60.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sign_copy_types_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default types
INSERT INTO `sign_copy_types` (`name_bn`, `name_en`, `code`, `cost`, `is_active`, `created_at`, `updated_at`) VALUES
('১৩ ডিজিট/নিবন্ধন/ধরন নং দিয়ে', '13 Digit/Registration/Type No', '60tk', 60.00, 1, NOW(), NOW()),
('১০/১২/১৭ ডিজিটি দিয়ে', '10/12/17 Digit', '60tk_old', 60.00, 1, NOW(), NOW());

-- Create sign_copy_orders table (your existing table)
CREATE TABLE `sign_copy_orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '60tk or 60tk_old',
  `nid_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 60.00,
  `file_path` varchar(255) DEFAULT NULL,
  `receipt` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=processing, 2=completed, 3=rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sign_copy_orders_user_id_foreign` (`user_id`),
  CONSTRAINT `sign_copy_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;