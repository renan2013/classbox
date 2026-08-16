-- ========================================================
-- CLASSBOX CMS V3 & SITIO WEB - DUMP SQL PARA HOSTINGER
-- Fecha: 2026-08-16 22:14:22
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';

-- --------------------------------------------------------
-- Estructura de tabla para `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_08_16_000001_create_modules_and_user_modules_tables', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_08_16_000002_create_categories_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_08_16_000003_create_posts_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_08_16_000004_create_attachments_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_08_16_000005_create_menus_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_08_16_000006_create_client_data_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_08_16_000007_create_testimonios_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_08_16_000008_create_matriculas_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_08_16_000009_create_graduaciones_tables', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_08_16_000010_create_frontend_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_08_16_061349_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2026_08_16_000011_create_media_files_table', '2');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2026_08_16_000012_create_banners_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2026_08_16_000013_create_pages_table', '3');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2026_08_16_000014_add_advanced_settings_to_client_data_table', '4');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('19', '2026_08_16_000015_create_home_sections_table', '5');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('20', '2026_08_16_000016_add_maintenance_bypass_key_to_client_data_table', '6');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('21', '2026_08_16_000017_add_theme_colors_to_client_data_table', '7');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('22', '2026_08_16_000018_add_overlay_style_to_banners_table', '8');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('23', '2026_08_16_000019_add_slider_overlay_style_to_client_data_table', '9');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('24', '2026_08_16_000020_add_text_styling_and_alignment_to_banners_and_client_data_tables', '10');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('25', '2026_08_16_000021_add_vertical_alignment_to_banners_and_client_data_tables', '11');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('26', '2026_08_16_000022_add_slider_default_texts_to_client_data_table', '12');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('27', '2026_08_16_000023_create_portfolio_tables', '13');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('28', '2026_08_16_000024_add_font_weight_and_typography_to_sliders', '14');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('29', '2026_08_16_000025_add_slider_visibility_toggles_to_tables', '15');

-- --------------------------------------------------------
-- Estructura de tabla para `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NULL,
  `name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `users`
INSERT INTO `users` (`id`, `username`, `full_name`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'renangalvan', 'Renan Galvan', 'Renan Galvan', 'admin@classbox.com', '$2y$12$RatAPNnt10QaeuIJJKGAU.subt91utaA8MOXDnMDTH6rNYUF5py6O', 'admin', '4zQ4SqNUDgcd89tI6gZKLNVjbM4lhmHPVWpDRfoN2t1dmNmyTmXjqfvo66yM', '2026-08-16 06:15:55', '2026-08-16 18:46:59');

-- --------------------------------------------------------
-- Estructura de tabla para `password_reset_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `sessions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(255) NULL,
  `user_agent` LONGTEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('TH6ifjWcX9uSHnHEGB45tcFpASEmfBTl1LCqwVLC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicDhYaXMxSmp6MENXVEREYk50b2lyeG15b2VTZWVsME1kN0VwSnhEaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786901282');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('lhNFEokSuphHiFUr9S1bNmZOYHAXMrA57ln6fVie', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWl2N0NSTm8wUXIzTE45UllMRjJMWEI2dkdJWWZ6MjkxZElFZ0o5YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786901527');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('hHpOnE9vHmglxUw6f4ovnO66R6daPds75hUmQfO6', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM1REOGh5WjNoVzhyQTVuQWd5V083d2hwano4SEE2dXpyakpGeHdQaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', '1786902313');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('xzI7S4Vf88FG37MsZgBsum0q5yC6TvCsl5gqqqMa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnc4bjdJWEVRZkRoWUk5QlRYU0hWeXZQMmtUV3hWbHo0bmlwMTViYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786902284');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('XhgFHFPvlhG2NLqAVHwBzqrtQTX98EQVbCXSWWM0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOExMQTEwNkgzQ3hxZU51cTdYdnFza1l3cjdBSW1TN2tDaE1mUW5sbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786902316');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('KobwJxxIb3iMLDWUonS6MVKrLP749zCuQwhh1LFP', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaXEzU3RsZEpCWnlPclhJdU16Wm1MdWlVd2hyWTJNbUFhQWJ0VjNIViI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcG9zdHMvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjE4OiJhZG1pbi5wb3N0cy5jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', '1786903816');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('KuOWh3WaBMpqrRQqDEbW773rYj8pM4qs01jKaQp9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVFiRDdEQktVbko4SUIzNGtUOHJxZ1h5SUJaY1RpZUptMlI1RU9kQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786903853');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Qy4dK7r9AoZBbQ4GBZLmJKIjxcOuRNZddzZuhbkw', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY1JmUmxrYkdPbTM1TVluR1hSSFJRb1hIUEVnSzRLTDg4VThIbWF0YyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bvc3RzIjtzOjU6InJvdXRlIjtzOjE3OiJhZG1pbi5wb3N0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786904478');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('w6q9CkXk9m3PWmAWIIgAcpN0ERiv3IaAQUSJtqd5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0lUWlFvTHlQME1Qc2ZSa3pSSHBaeEJMV0ZnZGdPUzQ3Z2FxckN3SCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786904529');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('GE3blsExTsOk3f9Vheqht5SCHRXgdVGZkCzHBCG3', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNlFta3piQ2tzWWlqTFJCTU1vRGJVVVZ6ZWNFQ3V1NXFXS3Q5aHQ4aCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bvc3RzIjtzOjU6InJvdXRlIjtzOjE3OiJhZG1pbi5wb3N0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786904717');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Hee1kBOwcYY2QLPRLMtEDBKZU1jxeiArM9EulPLf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkd6aVJYMVhvb0VYTjdzYWhNT1hQZFg1NHJVOWEyc3JYQzZDRUNVQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786904926');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('t0HecpzIDQCwJYNDTmJC7d1z87rpGNZRHRvpNG02', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiekFPYjNXRERJdnp1cTUwN29mdlRqZXFDODl5T3ZyallXMjNrQWlvUSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bvc3RzIjtzOjU6InJvdXRlIjtzOjE3OiJhZG1pbi5wb3N0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786904932');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('oUmzDFKL1yri5wjCRfVGSfObpmb8udYqhyvQOSrs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWx3djRXa2R0eFd2TkpSTXhJTjA2bjJzcFZ3ejdlWnVJTm5ia2xYYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786905033');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('doXS6dFVYbtFMcdqvgUn106bhKSGR1pRroslqdcQ', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV2VBVVlEMzJ1QzhPZlhxRnRObU4wVzRHd0JPS3gzOVF1eExHNzhabyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bvc3RzIjtzOjU6InJvdXRlIjtzOjE3OiJhZG1pbi5wb3N0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786905091');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('7FlQHRhKkepP3jdDfNnOoX4CTB7qAL4l2gPd25mq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFZIbE1EUjNOa3ZPOW5RaXBWZDA1aFc1bVNIS0dIRjV5THNYVW1hbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786905699');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('vw4j886U9XRHqzPDnE5WyNsbylYuv9DK1GtIKwvy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1ZDc01XQjUzbENVcmdpR0FrWExreUoyVVRQYUVIYUJlYjl0Z2EwWiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906198');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('8kahz7ZwBr1u3uxyaTemlbP9Q8qgoBjmvz9hImCJ', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQkIyeDZZemRNS0g1NFRLSkhCYnNYY2Q2WW8wR0RoVm9hMkRqTXpWdCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906382');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('nzMnYdc1qMFyCPkZ1unAvblRZ2csAooYD1dC8TmS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiak9laHJZcmdxYm9sMUlQTXh5VUxTM2hacThVM1VkSWZUOWtEaHZDbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bvc3RzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906327');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('vBsbi6naV1Cm9Gj6dbsumSPxwB4CQVZWcBUK0XfK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2d3RGJTZlFBUUQyOVlQTTMyNDR1dnJXNjFqRVgwM1ZKYVlYMFo5MSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2xvZ2luIjtzOjU6InJvdXRlIjtzOjExOiJhZG1pbi5sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786906328');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('1VLkdwZf2t1Ul4XgZLJaAHOtJoScQJSCcFPTx5Hv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlFUNjlVWmR4OGVNdXBDc1h3bTNMWk9nNzN5ejlJTlhncGFJdTROSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MC9jb250YWN0byI7czo1OiJyb3V0ZSI7czoxMjoic2l0ZS5jb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1786906410');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('RTYa8OOyUuUIDGUxv88am6YFJkbfffjZ6vnzwQGm', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRWlZaXlGMW9meHpTdHpkbDlBOTgzcnhqcVREdWVHeFpTVVVhdUZTeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1786906482');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('JaVDZH85EiDk4l8GqVUgzyC37LCwW4H47czTcpOd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWJIM2dVRU5vVUFua001dXhFQVVUZXZiR0tRMUdxbklOdUxVWWY0TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906500');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('3njqjczlTZYz1VcxlzCWXeLTSI7HvNzWJI8GpQYI', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQXI1WWhzemMzc0I2b3dQaVZrVG9taW11VGRLR2M3S3ZHdWwyYkNaNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO319', '1786906576');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('rgNBPD2sbklXg4JFUY6tWYet6sMBvviN7OODuWlI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0hFUnlTREJkVVJTMHRvcng3d3dWV1lQN0RYMmlyMUhIaHVzcXB0ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906582');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('EgRi2KH0fmA50Fm0LUT4wipDCtLtg9P4aXZOwjoC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib3EwRlFiSm1oWm05OU5PRlZPaGtkM1l4VGhxaWlzNkRaV1JiUWhrUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906734');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('XVkB7CsDWXrno7h7StUXpiCQLTK3AAILugZMiUI8', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHFLc2NtZnRqMldwaVZhREVOVzBiTHU1T29qV0sxRmdIUnZ1cEhsVCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786906753');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('DeHOUtJPlx1xymClbAzAU4oEW9jPYjMWIYSBiy4W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWFqc2VORWtneERnazc3VkFSVzhqRlY0QnBIalJKbGd0TGE5cWhReiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MC9jb250YWN0byI7czo1OiJyb3V0ZSI7czoxMjoic2l0ZS5jb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1786906851');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('7RTxzHPHgUzKaCuYzkxUR4lKAP8HJpU0BXiFPRxr', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSEJpWllYVDgyQjRmRXNaU0xVNnZBZkQ1WXBBZDdRdVRkQWtIUzlLVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO319', '1786907004');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('1FismLmThGyrSf3Chnz9WN3GmFyEXzBRletZHrnI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEttc0xUZUtVWVExd2tRTXIwVnJSdGx2MTJaWjZ0VUVUSTlGQWMwdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907017');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('Z0NIr6fnkWfDgtO4XnVtZIPjvJIhtuyavCOAovxu', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWTFRb3ZuSmhMcW0wWlNVTlVrcmt2Yldld2RMZVRvTTJaUzhKVDFNOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1786907184');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('GJG1la5zpjqUrhTJCfG0Kr3RKT3G9KO9olIsstHy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHRCQTd2aGxFTmZCS29EVGdpdkRqcFowYWNkeEpMSm5BR3U5WU10aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907188');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ojQCYiO83ERzUvsePVUEU9do22jrmV2k50Pccwip', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFZqVWFmMktmeFp3aVA2dHVkVFNLbzdFNGEzZDcxTTV6ekZ1TlRVbCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907266');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('ymQo5Hu2CiHKlE6hMrJI2D2YSnP63JpwlllJryId', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3FmUnZGMVVwYkxEaG5odERpSTZMSFZPM0d1ZGlHZWNSTERZNFdrVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907404');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('AF1aaVYPHckBrWn2A4QmTL0f8vuhQtpVJBaM411W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFRVbUw2RHZzdVdja29NbFFpSDdEMUlOV29NT1lZQWRtblBrVjdobyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907377');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('PNN7nn1f2QWr010cpA8IRIXK6nziwPTO68ecB8Xm', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVlkybm5CZTZwclRKbVV0NklOVXJUakZuYTljMURLaU9GTEVQUGxHNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2hvbWUtc2VjdGlvbnMiO3M6NToicm91dGUiO3M6MjU6ImFkbWluLmhvbWVfc2VjdGlvbnMuaW5kZXgiO319', '1786907464');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('jJj8x7q3cF2AWSPbknBqWkHTo84QKNTaUcvKXcB6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNVFIWVh3eVdFMGpMeW5JNGhYUzRwdWlKZ0g4M0c2S09ySEVLUUhXNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MC9jYXRlZ29yaWEvMiI7czo1OiJyb3V0ZSI7czoxMzoic2l0ZS5jYXRlZ29yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786907490');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('sVn5gIbVedUw5y03ZyfrWerabBaez9Ezm9nATqiz', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3VhYjdQV3JYamFTMko3c3d3d0YxU2YyMTFPZ29uRG1wanBoTjVybyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2NsaWVudC1kYXRhIjtzOjU6InJvdXRlIjtzOjIzOiJhZG1pbi5jbGllbnRfZGF0YS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', '1786907799');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('phM21mqo9TUc9LOnQg7mgPXC84lKreRYUYWNVZB4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2FWOVFLaUF1bU54OWFtcVlXTkU0bFJKVjNyREhxTkllN1pPWFZhYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786908002');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('KqBoA92NXSc58CmnSjInee6CETSX5FV07juP73eL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; es-CR) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFdWeHhzSmRmN2l5bUFRRGRkbFBIM2d4QVFrNnVVWFJyc2JLQzBGYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786907906');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('HnBs6lGrKGPBMXkqEJWwDftixoPgqIHvWfjxwxQa', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSklyN095R3ZMQUNPYXBXV1U5dndsanlLRVV4ak93TTBYZWtSOGUzOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2NsaWVudC1kYXRhIjtzOjU6InJvdXRlIjtzOjIzOiJhZG1pbi5jbGllbnRfZGF0YS5pbmRleCI7fX0=', '1786908143');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('euFItRafuL2hJUhi6PIbZywiiHpKBqjREfrEMcg3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGl6TmlHeHVKT1NzM1l0ZTZ5YnZzSlVUYzNzZGpLdjdkSTJGNHVLVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODA4MCI7czo1OiJyb3V0ZSI7czo5OiJzaXRlLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', '1786908149');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('IzYFLy0vVq0YhvZQPuP9jxRY4IKXUuuBbdVLlXOM', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUldCb2U5Wml6OUJrdmF2NGx1d29FUlJ0c0laR1BIdUFza0lMcDhnayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', '1786908293');

-- --------------------------------------------------------
-- Estructura de tabla para `cache`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` LONGTEXT NOT NULL,
  `expiration` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `cache_locks`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` BIGINT UNSIGNED NOT NULL,
  `reserved_at` BIGINT UNSIGNED NULL,
  `available_at` BIGINT UNSIGNED NOT NULL,
  `created_at` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `job_batches`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` BIGINT UNSIGNED NOT NULL,
  `pending_jobs` BIGINT UNSIGNED NOT NULL,
  `failed_jobs` BIGINT UNSIGNED NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` LONGTEXT NULL,
  `cancelled_at` BIGINT UNSIGNED NULL,
  `created_at` BIGINT UNSIGNED NOT NULL,
  `finished_at` BIGINT UNSIGNED NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `failed_jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` LONGTEXT NOT NULL,
  `queue` LONGTEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NULL DEFAULT NULL NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `modules`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `display_name` VARCHAR(255) NOT NULL,
  `description` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `modules`
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('1', 'posts', 'Gestor de Publicaciones', 'Crear, editar y eliminar publicaciones del blog.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('2', 'admisiones', 'Gestor de Admisiones', 'Gestiona las solicitudes de matrícula recibidas.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('3', 'menus', 'Gestor de Menús', 'Controlar la navegación del sitio web principal.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('4', 'users', 'Gestor de Usuarios', 'Administrar usuarios administradores.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('5', 'client_data', 'Datos Cliente', 'Gestionar la información de contacto y redes sociales del cliente.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('6', 'galerias', 'Gestor de Galerías', 'Administrar álbumes de fotos y graduaciones independientes.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('7', 'testimonios', 'Gestor de Testimonios', 'Administrar comentarios de estudiantes.', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('8', 'media', 'Biblioteca de Medios', 'Subir y administrar archivos, documentos, videos y fotos globales.', '2026-08-16 17:49:42', '2026-08-16 17:49:42');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('9', 'banners', 'Banners & Sliders', 'Administrar carruseles y banners promocionales del inicio.', '2026-08-16 18:06:35', '2026-08-16 18:06:35');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('10', 'pages', 'Páginas Estáticas', 'Crear y editar páginas independientes (Quiénes Somos, Políticas, etc.).', '2026-08-16 18:06:35', '2026-08-16 18:06:35');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('11', 'home_sections', 'Constructor de Portada', 'Configurar el orden y visualización de módulos de la página principal.', '2026-08-16 18:46:34', '2026-08-16 18:46:34');
INSERT INTO `modules` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES ('12', 'portfolio', 'Portafolio de Trabajos', 'Gestión de proyectos, logos, clientes y portafolio interactivo', '2026-08-16 20:31:59', '2026-08-16 20:31:59');

-- --------------------------------------------------------
-- Estructura de tabla para `user_modules`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `user_modules`;
CREATE TABLE `user_modules` (
  `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`, `module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `user_modules`
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '1');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '2');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '3');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '4');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '5');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '6');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '7');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '8');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '9');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '10');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '11');
INSERT INTO `user_modules` (`user_id`, `module_id`) VALUES ('1', '12');

-- --------------------------------------------------------
-- Estructura de tabla para `categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NULL,
  `image` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `categories`
INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES ('1', 'Técnicos', 'tecnicos', NULL, '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES ('2', 'Auxiliares', 'auxiliares', NULL, '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES ('3', 'Cursos Libres', 'cursos-libres', NULL, '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES ('4', 'Diplomados', 'diplomados', NULL, '2026-08-16 06:15:55', '2026-08-16 06:15:55');

-- --------------------------------------------------------
-- Estructura de tabla para `posts`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NULL,
  `synopsis` LONGTEXT NULL,
  `content` LONGTEXT NULL,
  `main_image` VARCHAR(255) NULL,
  `order` BIGINT UNSIGNED NOT NULL,
  `instructor_name` VARCHAR(255) NULL,
  `instructor_title` VARCHAR(255) NULL,
  `instructor_photo` VARCHAR(255) NULL,
  `show_in_instructors` BIGINT UNSIGNED NOT NULL,
  `is_published` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `posts`
INSERT INTO `posts` (`id`, `category_id`, `user_id`, `title`, `slug`, `synopsis`, `content`, `main_image`, `order`, `instructor_name`, `instructor_title`, `instructor_photo`, `show_in_instructors`, `is_published`, `created_at`, `updated_at`) VALUES ('2', '1', '1', 'gdhsfadghasfdhadfg', 'gdhsfadghasfdhadfg', 'dghfashdgfa dhgfashda', '<p>djhasdghgjasdfgadfghasd</p>', 'posts/876032f5-cc66-4f5a-860a-00e0d8993ec8.webp', '0', NULL, NULL, NULL, '0', '1', '2026-08-16 18:21:18', '2026-08-16 18:21:18');
INSERT INTO `posts` (`id`, `category_id`, `user_id`, `title`, `slug`, `synopsis`, `content`, `main_image`, `order`, `instructor_name`, `instructor_title`, `instructor_photo`, `show_in_instructors`, `is_published`, `created_at`, `updated_at`) VALUES ('3', '1', '1', 'hgafdhsfdhasd', 'hgafdhsfdhasd', 'sdytasgfdhasdf hdjasfgdhfasdv hgdasfdghasd hdgsafghda dhgasgfdghasd
dgfsadfgad ghdasfdhgfad hdgsafdhasfd', '<p>jhgdfaghjdf hjdasgfdhafdhga dhjasgdfayhdf dhasgfdhasfd</p>
<p>dhgfasgdfagdfga ghasfdhgafdghafdhadfh<br>gsfdghadfhadfhgadfhadfha</p>', 'posts/8725a9aa-0239-4a23-bbb8-97fe7e72f308.webp', '0', NULL, NULL, NULL, '0', '1', '2026-08-16 18:31:30', '2026-08-16 18:31:30');

-- --------------------------------------------------------
-- Estructura de tabla para `attachments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` BIGINT UNSIGNED NULL,
  `category_id` BIGINT UNSIGNED NULL,
  `type` VARCHAR(255) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `file_name` VARCHAR(255) NULL,
  `file_path` VARCHAR(255) NULL,
  `display_order` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `attachments`
INSERT INTO `attachments` (`id`, `post_id`, `category_id`, `type`, `value`, `file_name`, `file_path`, `display_order`, `created_at`, `updated_at`) VALUES ('1', '2', NULL, 'slider_image', 'sliders/29bab011-5872-496a-b5a9-dd7277f644c3.webp', 'conesup.webp', NULL, '0', '2026-08-16 20:19:37', '2026-08-16 20:19:37');
INSERT INTO `attachments` (`id`, `post_id`, `category_id`, `type`, `value`, `file_name`, `file_path`, `display_order`, `created_at`, `updated_at`) VALUES ('2', '3', NULL, 'slider_image', 'sliders/6cb19b76-d001-4688-8bdf-8c076ca47f1a.webp', 'website.webp', NULL, '0', '2026-08-16 20:24:43', '2026-08-16 20:24:43');
INSERT INTO `attachments` (`id`, `post_id`, `category_id`, `type`, `value`, `file_name`, `file_path`, `display_order`, `created_at`, `updated_at`) VALUES ('4', '2', NULL, 'youtube', 'https://youtu.be/dQrvTC-Efh8?list=PLZ01-gUMysyGU6yaNm7AaSlnxHR4f7irb', NULL, NULL, '0', '2026-08-16 21:33:12', '2026-08-16 21:33:12');

-- --------------------------------------------------------
-- Estructura de tabla para `menus`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `display_order` BIGINT UNSIGNED NOT NULL,
  `parent_id` BIGINT UNSIGNED NULL,
  `target` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `menus`
INSERT INTO `menus` (`id`, `title`, `url`, `display_order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES ('1', 'Inicio', '/', '1', NULL, '_self', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `menus` (`id`, `title`, `url`, `display_order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES ('2', 'Quiénes Somos', 'about.php', '2', NULL, '_self', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `menus` (`id`, `title`, `url`, `display_order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES ('3', 'Cursos', 'index.php', '3', NULL, '_self', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `menus` (`id`, `title`, `url`, `display_order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES ('4', 'Graduaciones', 'graduaciones.php', '4', NULL, '_self', '2026-08-16 06:15:55', '2026-08-16 06:15:55');
INSERT INTO `menus` (`id`, `title`, `url`, `display_order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES ('5', 'Contacto', 'contact.php', '5', NULL, '_self', '2026-08-16 06:15:55', '2026-08-16 06:15:55');

-- --------------------------------------------------------
-- Estructura de tabla para `client_data`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `client_data`;
CREATE TABLE `client_data` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(255) NULL,
  `logo_path` VARCHAR(255) NULL,
  `whatsapp_country_code` VARCHAR(255) NOT NULL,
  `whatsapp_number` VARCHAR(255) NULL,
  `phone` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `address` LONGTEXT NULL,
  `google_maps_url` LONGTEXT NULL,
  `facebook_url` VARCHAR(255) NULL,
  `instagram_url` VARCHAR(255) NULL,
  `youtube_url` VARCHAR(255) NULL,
  `tiktok_url` VARCHAR(255) NULL,
  `linkedin_url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `favicon_path` VARCHAR(255) NULL,
  `logo_dark_path` VARCHAR(255) NULL,
  `website_url` VARCHAR(255) NULL,
  `schedule_info` VARCHAR(255) NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` LONGTEXT NULL,
  `meta_keywords` LONGTEXT NULL,
  `google_analytics_id` VARCHAR(255) NULL,
  `meta_pixel_id` VARCHAR(255) NULL,
  `custom_head_scripts` LONGTEXT NULL,
  `custom_body_scripts` LONGTEXT NULL,
  `maintenance_mode` BIGINT UNSIGNED NOT NULL,
  `maintenance_message` LONGTEXT NULL,
  `maintenance_bypass_key` VARCHAR(255) NULL,
  `primary_color` VARCHAR(255) NULL,
  `secondary_color` VARCHAR(255) NULL,
  `topbar_bg_color` VARCHAR(255) NULL,
  `topbar_text_color` VARCHAR(255) NULL,
  `navbar_bg_color` VARCHAR(255) NULL,
  `navbar_text_color` VARCHAR(255) NULL,
  `footer_bg_color` VARCHAR(255) NULL,
  `footer_text_color` VARCHAR(255) NULL,
  `card_bg_color` VARCHAR(255) NULL,
  `card_border_color` VARCHAR(255) NULL,
  `slider_overlay_style` VARCHAR(255) NULL,
  `slider_content_alignment` VARCHAR(255) NULL,
  `slider_title_color` VARCHAR(255) NULL,
  `slider_title_size` VARCHAR(255) NULL,
  `slider_subtitle_color` VARCHAR(255) NULL,
  `slider_content_vertical_alignment` VARCHAR(255) NULL,
  `slider_default_subtitle` VARCHAR(255) NULL,
  `slider_default_title` VARCHAR(255) NULL,
  `slider_default_button_text` VARCHAR(255) NULL,
  `slider_default_button_url` VARCHAR(255) NULL,
  `slider_title_weight` VARCHAR(255) NULL,
  `slider_font_family` VARCHAR(255) NULL,
  `slider_button_style` VARCHAR(255) NULL,
  `slider_show_subtitle` BIGINT UNSIGNED NOT NULL,
  `slider_show_title` BIGINT UNSIGNED NOT NULL,
  `slider_show_button` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `client_data`
INSERT INTO `client_data` (`id`, `company_name`, `logo_path`, `whatsapp_country_code`, `whatsapp_number`, `phone`, `email`, `address`, `google_maps_url`, `facebook_url`, `instagram_url`, `youtube_url`, `tiktok_url`, `linkedin_url`, `created_at`, `updated_at`, `favicon_path`, `logo_dark_path`, `website_url`, `schedule_info`, `meta_title`, `meta_description`, `meta_keywords`, `google_analytics_id`, `meta_pixel_id`, `custom_head_scripts`, `custom_body_scripts`, `maintenance_mode`, `maintenance_message`, `maintenance_bypass_key`, `primary_color`, `secondary_color`, `topbar_bg_color`, `topbar_text_color`, `navbar_bg_color`, `navbar_text_color`, `footer_bg_color`, `footer_text_color`, `card_bg_color`, `card_border_color`, `slider_overlay_style`, `slider_content_alignment`, `slider_title_color`, `slider_title_size`, `slider_subtitle_color`, `slider_content_vertical_alignment`, `slider_default_subtitle`, `slider_default_title`, `slider_default_button_text`, `slider_default_button_url`, `slider_title_weight`, `slider_font_family`, `slider_button_style`, `slider_show_subtitle`, `slider_show_title`, `slider_show_button`) VALUES ('1', 'CEFI - Centro de Formación Integral', 'client_data/89f55564-5758-402f-8d64-e5fc3881c87b.webp', '506', '87220999', '+(506) 22217870 / +(506) 22212502', 'contacto@ceficr.com', 'Costado oeste de la Clínica Bíblica
Torre Omega piso 9, San José, Costa Rica.', NULL, 'https://www.facebook.com/ceficr', 'https://www.instagram.com/ceficr', 'https://www.youtube.com', NULL, NULL, '2026-08-16 06:15:55', '2026-08-16 21:11:24', NULL, 'client_data/136879a2-af98-42a6-9b52-04e61712a277.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 'cefi2026', '#5FB230', '#181d38', '#181d38', '#ffffff', '#07609c', '#ebecf4', '#07609c', '#ffffff', '#ffffff', '#e2e8f0', 'none', 'center', '#334155', 'md', '#ffffff', 'bottom', '', 'Creamos su página web de acuerdo a sus necesidades', 'Quiero saber más', '/contacto', 'light', 'roboto', 'text_link', '0', '1', '1');

-- --------------------------------------------------------
-- Estructura de tabla para `testimonios`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `testimonios`;
CREATE TABLE `testimonios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `profesion` VARCHAR(255) NULL,
  `comentario` LONGTEXT NOT NULL,
  `foto` VARCHAR(255) NULL,
  `video_iframe` LONGTEXT NULL,
  `rating` BIGINT UNSIGNED NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `testimonios`
INSERT INTO `testimonios` (`id`, `nombre`, `profesion`, `comentario`, `foto`, `video_iframe`, `rating`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Alberto Garcés', 'Estudiante de Mercadeo', 'Excelente metodología práctica y atención del profesorado.', NULL, '<iframe src=\"https://drive.google.com/file/d/0B31D5wJfU_a6bW8tQ0tISWN6Znc/preview?resourcekey=0-BepZZT_8QpWgBT1wvv5KtA\" width=\"640\" height=\"480\"></iframe>', '5', '1', '2026-08-16 06:15:55', '2026-08-16 06:15:55');

-- --------------------------------------------------------
-- Estructura de tabla para `matriculas`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `matriculas`;
CREATE TABLE `matriculas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `programa` VARCHAR(255) NOT NULL,
  `nacionalidad` VARCHAR(255) NOT NULL,
  `codigo_pais` VARCHAR(255) NULL,
  `email` VARCHAR(255) NOT NULL,
  `whatsapp` VARCHAR(255) NOT NULL,
  `foto` VARCHAR(255) NULL,
  `documentos` VARCHAR(255) NULL,
  `fecha_nacimiento` VARCHAR(255) NULL,
  `estado` VARCHAR(255) NOT NULL,
  `notas` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `graduaciones`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `graduaciones`;
CREATE TABLE `graduaciones` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL,
  `title` VARCHAR(255) NOT NULL,
  `synopsis` LONGTEXT NULL,
  `main_image` VARCHAR(255) NULL,
  `video_url` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `graduaciones`
INSERT INTO `graduaciones` (`id`, `user_id`, `title`, `synopsis`, `main_image`, `video_url`, `created_at`, `updated_at`) VALUES ('1', '1', 'Graduación Promoción 2025', 'Entrega de certificados oficiales a los graduados en Diseño Gráfico y Programación.', NULL, NULL, '2026-08-16 18:58:01', '2026-08-16 18:58:01');
INSERT INTO `graduaciones` (`id`, `user_id`, `title`, `synopsis`, `main_image`, `video_url`, `created_at`, `updated_at`) VALUES ('2', '1', 'Graduación Promoción 2024', 'Celebración de clausura y proyectos destacados de fin de curso.', NULL, NULL, '2026-08-16 18:58:01', '2026-08-16 18:58:01');

-- --------------------------------------------------------
-- Estructura de tabla para `graduaciones_attachments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `graduaciones_attachments`;
CREATE TABLE `graduaciones_attachments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `graduacion_id` BIGINT UNSIGNED NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `file_name` VARCHAR(255) NULL,
  `display_order` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `frontend_users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `frontend_users`;
CREATE TABLE `frontend_users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `personal_access_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` LONGTEXT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `abilities` LONGTEXT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `media_files`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `media_files`;
CREATE TABLE `media_files` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_type` VARCHAR(255) NOT NULL,
  `mime_type` VARCHAR(255) NULL,
  `file_size` BIGINT UNSIGNED NOT NULL,
  `dimensions` VARCHAR(255) NULL,
  `alt_text` VARCHAR(255) NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `media_files`
INSERT INTO `media_files` (`id`, `name`, `file_name`, `file_path`, `file_type`, `mime_type`, `file_size`, `dimensions`, `alt_text`, `user_id`, `created_at`, `updated_at`) VALUES ('1', 'inbox_cefi_propuesta_alquiler', 'inbox-cefi-propuesta-alquiler-gacuZK.pdf', 'media/inbox-cefi-propuesta-alquiler-gacuZK.pdf', 'document', 'application/pdf', '23635', NULL, 'inbox_cefi_propuesta_alquiler', '1', '2026-08-16 18:03:48', '2026-08-16 18:03:48');
INSERT INTO `media_files` (`id`, `name`, `file_name`, `file_path`, `file_type`, `mime_type`, `file_size`, `dimensions`, `alt_text`, `user_id`, `created_at`, `updated_at`) VALUES ('2', 'Gemini_Generated_Image_rcpnv6rcpnv6rcpn', '69fd2f75-5b98-4401-bfa1-43e0e46aa353.webp', 'media/69fd2f75-5b98-4401-bfa1-43e0e46aa353.webp', 'image', 'image/webp', '68990', NULL, 'Gemini_Generated_Image_rcpnv6rcpnv6rcpn', '1', '2026-08-16 18:04:23', '2026-08-16 18:04:23');

-- --------------------------------------------------------
-- Estructura de tabla para `banners`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `subtitle` VARCHAR(255) NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `mobile_image_path` VARCHAR(255) NULL,
  `button_text` VARCHAR(255) NULL,
  `button_url` VARCHAR(255) NULL,
  `order` BIGINT UNSIGNED NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `start_date` TIMESTAMP NULL DEFAULT NULL NULL,
  `end_date` TIMESTAMP NULL DEFAULT NULL NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `overlay_style` VARCHAR(255) NOT NULL,
  `content_alignment` VARCHAR(255) NULL,
  `title_color` VARCHAR(255) NULL,
  `title_size` VARCHAR(255) NULL,
  `subtitle_color` VARCHAR(255) NULL,
  `button_style` VARCHAR(255) NULL,
  `content_vertical_alignment` VARCHAR(255) NULL,
  `title_weight` VARCHAR(255) NULL,
  `font_family` VARCHAR(255) NULL,
  `show_subtitle` BIGINT UNSIGNED NOT NULL,
  `show_title` BIGINT UNSIGNED NOT NULL,
  `show_button` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `pages`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `content` LONGTEXT NULL,
  `featured_image` VARCHAR(255) NULL,
  `meta_title` VARCHAR(255) NULL,
  `meta_description` LONGTEXT NULL,
  `is_published` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para `home_sections`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `home_sections`;
CREATE TABLE `home_sections` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_key` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NULL,
  `subtitle` VARCHAR(255) NULL,
  `order` BIGINT UNSIGNED NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `settings` LONGTEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `home_sections`
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('1', 'slider', 'Carrusel / Sliders de Portada', NULL, NULL, '1', '1', '{\"autoplay\":true,\"interval\":5000}', '2026-08-16 18:46:34', '2026-08-16 19:10:52');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('2', 'categories', 'Áreas de Formación / Escuelas', 'Áreas de Formación', 'Nuestras Escuelas', '2', '0', '{\"show_courses_count\":true}', '2026-08-16 18:46:34', '2026-08-16 19:10:52');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('3', 'featured_posts', 'Cursos Populares / Destacados', 'Programas Destacados', 'Cursos Populares', '3', '1', '{\"limit\":6,\"show_category_badge\":true}', '2026-08-16 18:46:34', '2026-08-16 19:10:52');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('4', 'testimonials', 'Testimonios de Estudiantes', 'Lo Que Dicen Nuestros Estudiantes', 'Testimonios', '4', '0', '{\"limit\":5}', '2026-08-16 18:46:34', '2026-08-16 19:10:52');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('5', 'graduaciones', 'Graduaciones & Galería de Éxito', 'Nuestras Graduaciones', 'Casos de Éxito', '5', '0', '{\"limit\":4}', '2026-08-16 18:46:34', '2026-08-16 20:20:21');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('6', 'cta_banner', 'Banner de Matrícula / Llamada a la Acción', '¿Listo para Iniciar Tu Carrera Profesional?', 'Matrícula Abierta 2026', '6', '0', '{\"button_text\":\"Solicitar Informaci\\u00f3n\",\"button_url\":\"\\/contacto\"}', '2026-08-16 18:46:34', '2026-08-16 19:11:04');
INSERT INTO `home_sections` (`id`, `section_key`, `name`, `title`, `subtitle`, `order`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES ('8', 'portfolio', 'Portafolio de Trabajos', 'Portafolio de Trabajos', 'A lo largo de más de 25 años de trabajo queremos compartir algunos de nuestros trabajos que ponemos a su disposición', '7', '1', '{\"limit\":12,\"show_filters\":true}', '2026-08-16 20:31:59', '2026-08-16 20:31:59');

-- --------------------------------------------------------
-- Estructura de tabla para `portfolio_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `portfolio_categories`;
CREATE TABLE `portfolio_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `order` BIGINT UNSIGNED NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `portfolio_categories`
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Logos', 'logos', '1', '1', NULL, NULL);
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Website', 'website', '2', '1', NULL, NULL);
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Impresiones', 'impresiones', '3', '1', NULL, NULL);
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Varios', 'varios', '4', '1', NULL, NULL);

-- --------------------------------------------------------
-- Estructura de tabla para `portfolio_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `portfolio_items`;
CREATE TABLE `portfolio_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NULL,
  `title` VARCHAR(255) NOT NULL,
  `client_name` VARCHAR(255) NULL,
  `description` LONGTEXT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `project_url` VARCHAR(255) NULL,
  `order` BIGINT UNSIGNED NOT NULL,
  `is_active` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcado de datos para la tabla `portfolio_items`
INSERT INTO `portfolio_items` (`id`, `category_id`, `title`, `client_name`, `description`, `image_path`, `project_url`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', '1', 'Diego Mecánica', 'Diego Mecánica', 'Este logo concatena el concepto de parte de un dashboard y las iniciales del dueño de la empresa', 'portfolio/6f66cc83-1db0-4984-ab91-ac1f4a5d35be.webp', NULL, '0', '1', '2026-08-16 20:45:24', '2026-08-16 20:45:24');
INSERT INTO `portfolio_items` (`id`, `category_id`, `title`, `client_name`, `description`, `image_path`, `project_url`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', '1', 'Paola', 'Paola', NULL, 'portfolio/c656d9be-7c69-4537-8f24-9ed1dcded92c.webp', NULL, '0', '1', '2026-08-16 20:58:16', '2026-08-16 20:58:16');

SET FOREIGN_KEY_CHECKS=1;
