ALTER TABLE `reviews`
ADD COLUMN `reply` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
ADD COLUMN `replied_at` timestamp NULL DEFAULT NULL;
