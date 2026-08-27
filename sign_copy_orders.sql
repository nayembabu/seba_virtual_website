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
