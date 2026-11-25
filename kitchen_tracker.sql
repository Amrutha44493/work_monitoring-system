-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table kitchen_tracker.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.cache: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.cache_locks: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.categories: ~8 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Carcase', 'carcase', NULL, 1, 0, '2026-09-24 09:10:45', '2026-10-02 09:14:57', NULL),
	(2, 'Shutter', 'shutter', NULL, 1, 2, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(3, 'Accessories', 'accessories', NULL, 1, 0, '2026-09-24 09:10:45', '2026-10-10 02:25:33', NULL),
	(4, 'Wardrobe', 'wardrobe', NULL, 1, 4, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(5, 'Accessories2', 'accessories2', 'testingg', 1, 5, '2026-09-24 21:42:00', '2026-09-25 01:25:03', '2026-09-25 01:25:03'),
	(6, 'sfddfksjlf', 'sfddfksjlf', 'sdfsdfsdfsdio', 1, 0, '2026-09-26 08:52:25', '2026-09-26 08:54:39', '2026-09-26 08:54:39'),
	(7, 'testing', 'testing', 'gggggggggggggg', 1, 0, '2026-10-14 19:22:48', '2026-10-14 19:23:41', '2026-10-14 19:23:41'),
	(8, 'fsfsds', 'fsfsds', NULL, 1, 0, '2026-10-14 19:46:33', '2026-10-14 19:46:51', '2026-10-14 19:46:51');

-- Dumping structure for table kitchen_tracker.customers
DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.customers: ~2 rows (approximately)
INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `city`, `state`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Geetha', '874569874563', 'geetha123@gmail.com', 'geetha nageer,koovangal ,palakkad', 'Palakkad', 'Kerala', 1, '2026-10-03 12:31:02', '2026-11-10 19:51:39', '2026-11-10 19:51:39'),
	(2, 'Rajan', '7451236520', 'rajankj@gmail.com', 'Kz hajhdjkahjasd', 'CAlicut', 'Kerala', 1, '2026-10-14 19:59:46', '2026-11-10 19:51:33', '2026-11-10 19:51:33'),
	(3, 'Lian', '9874562223', 'liandfgs@gmail.com', 'HR nagar,Btm Layout,Kerala', 'Calicut', 'Kerala', 1, '2026-11-10 19:52:49', '2026-11-10 19:52:49', NULL);

-- Dumping structure for table kitchen_tracker.employees
DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `team_leader_id` bigint unsigned DEFAULT NULL,
  `role` enum('employee','team_leader') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `joining_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_employee_code_unique` (`employee_code`),
  KEY `employees_user_id_foreign` (`user_id`),
  KEY `employees_team_leader_id_foreign` (`team_leader_id`),
  CONSTRAINT `employees_team_leader_id_foreign` FOREIGN KEY (`team_leader_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.employees: ~8 rows (approximately)
INSERT INTO `employees` (`id`, `employee_code`, `name`, `phone`, `email`, `user_id`, `team_leader_id`, `role`, `is_active`, `joining_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'EMP-001', 'Asokan', '98745632152', 'ashoktracker@gmail.com', NULL, NULL, 'team_leader', 1, '2025-04-13', '2026-10-03 12:03:50', '2026-11-10 19:46:31', '2026-11-10 19:46:31'),
	(2, 'EMP-002', 'Vaish', '9865428745', 'vaishwer@gmail.com', NULL, 1, 'employee', 1, '2026-10-01', '2026-10-03 12:08:15', '2026-11-10 19:48:59', '2026-11-10 19:48:59'),
	(3, 'EMP-003', 'Akhil', '85764565412', 'akhilasok@gmail.com', NULL, 1, 'employee', 1, '2026-10-01', '2026-10-03 12:11:44', '2026-11-10 19:48:53', '2026-11-10 19:48:53'),
	(4, 'EMP-004', 'Amrutha', '9865874230', 'amrutha@gmail.com', NULL, NULL, 'team_leader', 1, '2026-10-01', '2026-10-14 19:43:18', '2026-11-10 19:46:23', '2026-11-10 19:46:23'),
	(5, 'EMP-005', 'Lian', '9856320111', 'lianv@gmail.com', NULL, 4, 'employee', 1, '2026-10-14', '2026-10-14 19:55:27', '2026-11-10 19:48:48', '2026-11-10 19:48:48'),
	(6, 'EMP-006', 'Vaishakh', '9852456123', 'vaishakhs123@gmail.com', 6, NULL, 'team_leader', 1, '2025-02-01', '2026-11-10 19:47:45', '2026-11-10 19:47:45', NULL),
	(7, 'EMP-007', 'Akhil', '9875365952', 'akhilpsk456@gmail.com', 7, 6, 'employee', 1, '2026-01-01', '2026-11-10 19:50:16', '2026-11-10 19:50:16', NULL),
	(8, 'EMP-008', 'Asokan', '9856324512', 'ashokanrt456@gmail.com', 8, 6, 'employee', 1, '2026-01-02', '2026-11-10 19:51:05', '2026-11-10 19:51:21', NULL);

-- Dumping structure for table kitchen_tracker.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.fitting_types
DROP TABLE IF EXISTS `fitting_types`;
CREATE TABLE IF NOT EXISTS `fitting_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `standard_time` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'per piece',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fitting_types_category_id_foreign` (`category_id`),
  CONSTRAINT `fitting_types_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.fitting_types: ~46 rows (approximately)
INSERT INTO `fitting_types` (`id`, `category_id`, `name`, `standard_time`, `unit`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'Base Carcase', 25, 'per box', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(2, 1, 'Tall Carcase', 30, 'per box', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(3, 1, 'Wall Box', 35, 'per box', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(4, 1, 'Loft Box', 30, 'per box', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(5, 1, 'Loft Frame Work', 90, 'per 8ft', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(6, 1, 'Breakfast Table', 120, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(7, 1, 'Counter Top Multiwood', 20, 'per sheet', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(8, 1, 'Hob Cutting', 15, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(9, 1, 'Sink Cutting', 15, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(10, 1, 'Shelf Fitting', 10, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(11, 2, 'Base Shutter', 20, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(12, 2, 'Tall Shutter', 45, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(13, 2, 'Wall Shutter', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(14, 2, 'Loft Shutter', 40, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(15, 2, 'Drawer Facia', 20, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(16, 2, 'Dummy Fittings', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(17, 2, 'Built In Fridge Shutter', 180, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(18, 2, 'Dishwasher Shutter', 40, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(19, 2, 'Oven Fittings', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(20, 3, 'Tandam Box', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(21, 3, 'Inner Tandam Box', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(22, 3, 'Tall Unit', 90, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(23, 3, 'Corner Unit', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(24, 3, 'Waste Boy', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(25, 3, 'Rolling Shutter', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(26, 3, 'GTPT', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(27, 3, 'Avantos', 45, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(28, 3, 'Pocket Door System', 180, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(29, 3, 'Skirting L Type', 120, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(30, 3, 'Light Channel Fittings', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(31, 3, 'Cleaning Kitchen', 480, 'per kitchen', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(32, 3, 'Cornish 8ft', 90, 'per 8ft', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(33, 3, 'Glass Shelf', 10, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(34, 3, 'Knob/Handle', 10, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(35, 3, 'Push Open', 10, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(36, 3, 'Cutlery', 10, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(37, 3, 'Plate Tray', 15, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(38, 3, 'Wicker Basket', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(39, 3, 'Covering', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(40, 4, 'Wardrobe Carcase', 180, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(41, 4, 'Wardrobe Door', 60, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(42, 4, 'Drawer', 30, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(43, 4, 'Jewellery Tray', 45, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(44, 4, 'Handle', 15, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(45, 4, 'Knob', 15, 'per piece', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(46, 4, 'Lighting', 480, 'per wardrobe', NULL, 1, 0, '2026-09-24 09:10:45', '2026-09-24 09:10:45', NULL),
	(47, 1, 'gggggggggggggggggg', 23, 'per piece', 'kjkljlk', 1, 0, '2026-10-14 19:31:26', '2026-10-14 19:33:31', '2026-10-14 19:33:31'),
	(48, 1, 'mnmnm', 54, 'per piece', NULL, 1, 0, '2026-10-14 19:47:16', '2026-10-14 19:47:22', '2026-10-14 19:47:22');

-- Dumping structure for table kitchen_tracker.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.jobs: ~0 rows (approximately)
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"992199e9-dd12-4ad0-82cc-e10078170aca","displayName":"App\\\\Mail\\\\TeamLeaderWelcome","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":19:{s:8:\\"mailable\\";O:26:\\"App\\\\Mail\\\\TeamLeaderWelcome\\":4:{s:8:\\"employee\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:19:\\"App\\\\Models\\\\Employee\\";s:2:\\"id\\";i:4;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:8:\\"password\\";s:11:\\"password123\\";s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:17:\\"amrutha@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:13:\\"debounceOwner\\";s:0:\\"\\";s:15:\\"uniqueLockOwner\\";s:0:\\"\\";s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1792006998,"delay":null}', 0, NULL, 1792006998, 1792006998),
	(2, 'default', '{"uuid":"b3adce5e-d45c-4999-bf89-83f35412109c","displayName":"App\\\\Mail\\\\TeamLeaderWelcome","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"deleteWhenMissingModels":false,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":19:{s:8:\\"mailable\\";O:26:\\"App\\\\Mail\\\\TeamLeaderWelcome\\":4:{s:8:\\"employee\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:19:\\"App\\\\Models\\\\Employee\\";s:2:\\"id\\";i:6;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:8:\\"password\\";s:11:\\"password123\\";s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:22:\\"vaishakhs123@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:12:\\"messageGroup\\";N;s:12:\\"deduplicator\\";N;s:13:\\"debounceOwner\\";s:0:\\"\\";s:15:\\"uniqueLockOwner\\";s:0:\\"\\";s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;}","batchId":null},"createdAt":1794340068,"delay":null}', 0, NULL, 1794340068, 1794340068);

-- Dumping structure for table kitchen_tracker.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.job_batches: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_09_24_030308_create_permission_tables', 1),
	(5, '2026_09_24_030403_create_categories_table', 1),
	(6, '2026_09_24_030404_create_fitting_types_table', 1),
	(7, '2026_09_24_030405_create_customers_table', 1),
	(8, '2026_09_24_030406_create_projects_table', 1),
	(9, '2026_09_24_030407_create_employees_table', 1),
	(10, '2026_09_24_030408_create_project_fitting_items_table', 1),
	(11, '2026_09_24_030409_create_work_assignments_table', 1),
	(12, '2026_09_24_030410_create_work_logs_table', 1),
	(13, '2026_10_05_145424_add_team_leader_id_to_projects_table', 2),
	(14, '2026_10_09_235512_change_efficiency_column_in_work_logs', 3),
	(15, '2026_10_15_112913_fix_efficiency_decimal_in_work_logs', 4);

-- Dumping structure for table kitchen_tracker.model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.model_has_roles
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.model_has_roles: ~4 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 6),
	(3, 'App\\Models\\User', 7),
	(3, 'App\\Models\\User', 8);

-- Dumping structure for table kitchen_tracker.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.permissions: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.projects
DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `team_leader_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_address` text COLLATE utf8mb4_unicode_ci,
  `site_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expected_end_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed','on_hold','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_project_code_unique` (`project_code`),
  KEY `projects_customer_id_foreign` (`customer_id`),
  CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.projects: ~5 rows (approximately)
INSERT INTO `projects` (`id`, `project_code`, `customer_id`, `team_leader_id`, `name`, `site_address`, `site_city`, `start_date`, `expected_end_date`, `actual_end_date`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'PRJ-2026-0001', 1, NULL, 'Kitchen FItting-Rajan', 'NH Nagar,Calicut-19', 'Calicut', '2026-10-01', '2026-10-30', NULL, 'pending', 'Testingg', '2026-10-04 02:40:30', '2026-10-14 20:10:48', '2026-10-14 20:10:48'),
	(2, 'PRJ-2026-0002', 1, 1, 'Kitchen Fitting-Geetha', 'ZM,Calciut,Kerala', 'Calicut', '2026-10-09', '2026-10-10', NULL, 'pending', 'Fast complete', '2026-10-09 00:01:33', '2026-11-11 14:48:17', '2026-11-11 14:48:17'),
	(3, 'PRJ-2026-0003', 2, 4, 'Kitchen-Fitting-Rajan', 'kk nagar', 'Claiacut', '2026-10-08', '2026-10-28', '2026-10-29', 'pending', 'testingggg', '2026-10-14 20:16:08', '2026-11-11 14:27:13', '2026-11-11 14:27:13'),
	(4, 'PRJ-2026-0004', 3, 6, 'Kitchen Fitting', 'KR Nagar,Panamballi,Kochi,Kerala', 'Ernakulam', '2026-11-01', '2026-11-12', '2026-11-13', 'pending', 'Testingg', '2026-11-11 14:52:50', '2026-11-12 12:08:32', '2026-11-12 12:08:32'),
	(5, 'PRJ-2026-0005', 3, 6, 'Kitchen', NULL, 'calicut', '2026-11-01', '2026-11-30', NULL, 'pending', 'testing', '2026-11-12 12:09:45', '2026-11-12 12:09:45', NULL),
	(6, 'PRJ-2026-0006', 3, 6, 'Wadroe', 'dgfdfg', 'dgfd', '2026-11-01', '2026-11-26', NULL, 'pending', NULL, '2026-11-12 15:57:53', '2026-11-12 15:57:53', NULL);

-- Dumping structure for table kitchen_tracker.project_fitting_items
DROP TABLE IF EXISTS `project_fitting_items`;
CREATE TABLE IF NOT EXISTS `project_fitting_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `fitting_type_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `standard_time` int NOT NULL,
  `actual_time` int NOT NULL DEFAULT '0',
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_fitting_items_project_id_foreign` (`project_id`),
  KEY `project_fitting_items_fitting_type_id_foreign` (`fitting_type_id`),
  CONSTRAINT `project_fitting_items_fitting_type_id_foreign` FOREIGN KEY (`fitting_type_id`) REFERENCES `fitting_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_fitting_items_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.project_fitting_items: ~11 rows (approximately)
INSERT INTO `project_fitting_items` (`id`, `project_id`, `fitting_type_id`, `quantity`, `standard_time`, `actual_time`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 11, 1, 20, 0, 'pending', '2026-10-04 02:40:30', '2026-10-04 02:40:30'),
	(2, 1, 13, 1, 30, 0, 'pending', '2026-10-04 02:40:30', '2026-10-04 02:40:30'),
	(3, 2, 11, 1, 20, 0, 'pending', '2026-10-09 00:01:33', '2026-10-09 00:01:33'),
	(4, 2, 13, 1, 30, 0, 'pending', '2026-10-09 00:01:33', '2026-10-09 00:01:33'),
	(5, 3, 2, 1, 30, 0, 'pending', '2026-10-14 20:16:08', '2026-10-14 20:16:08'),
	(6, 3, 3, 1, 35, 0, 'pending', '2026-10-14 20:16:08', '2026-10-14 20:16:08'),
	(7, 4, 41, 1, 60, 0, 'pending', '2026-11-11 14:52:50', '2026-11-11 14:52:50'),
	(8, 4, 46, 1, 480, 0, 'pending', '2026-11-11 14:52:50', '2026-11-11 14:52:50'),
	(9, 5, 25, 1, 60, 0, 'pending', '2026-11-12 12:09:45', '2026-11-12 12:09:45'),
	(10, 5, 31, 1, 480, 0, 'pending', '2026-11-12 12:09:45', '2026-11-12 12:09:45'),
	(11, 6, 41, 1, 60, 0, 'pending', '2026-11-12 15:57:54', '2026-11-12 15:57:54'),
	(12, 6, 40, 1, 180, 0, 'pending', '2026-11-12 15:57:54', '2026-11-12 15:57:54'),
	(13, 6, 42, 1, 30, 0, 'pending', '2026-11-12 15:57:54', '2026-11-12 15:57:54');

-- Dumping structure for table kitchen_tracker.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.roles: ~2 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'web', '2026-09-24 09:10:44', '2026-09-24 09:10:44'),
	(2, 'team_leader', 'web', '2026-09-24 09:10:44', '2026-09-24 09:10:44'),
	(3, 'employee', 'web', '2026-09-24 09:10:44', '2026-09-24 09:10:44');

-- Dumping structure for table kitchen_tracker.role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.role_has_permissions: ~0 rows (approximately)

-- Dumping structure for table kitchen_tracker.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('YAP3FvVPYuSBHteeZjriK7hEymsRhFXjlo3MRWNh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI1VVcxamg4M0pMVXZxVW5wSEFXbUNRZ2F4Q3NWTU1XQWFVOXUwd0RUIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1794502959);

-- Dumping structure for table kitchen_tracker.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User', 'admin@kitchen.com', NULL, '$2y$12$YW6.wepXRv9Iqx8.vzG1r.Y3lXsLlwNBzEzPBJ/zCKdcV35SndWHO', NULL, '2026-09-24 09:10:45', '2026-09-24 09:10:45'),
	(6, 'Vaishakh', 'vaishakhs123@gmail.com', NULL, '$2y$12$iRF0whx6uzNt0BhpyUF/hOthpatB1l2HVb0fgmkyUiXlTDxHwRrAa', '1Ol0twV7zZWchk9IILe8sK5nFaCJ9XAk7Q5BS3Bza3PmPQQlZ5UYaQN9th7a', '2026-11-10 19:47:45', '2026-11-11 15:00:02'),
	(7, 'Akhil', 'akhilpsk456@gmail.com', NULL, '$2y$12$ihtHTaaOTNzJ1r6pTm4VHePA.1lFaiLWDd/kQD2WcMcNMaCaSCt7i', NULL, '2026-11-10 19:50:16', '2026-11-10 19:50:16'),
	(8, 'Ashokan', 'ashokanrt456@gmail.com', NULL, '$2y$12$quA5qo8MAFqViRalzM5maeZBo//sSzeDSceOmeOnMyBm067JO0BHy', NULL, '2026-11-10 19:51:05', '2026-11-10 19:51:05');

-- Dumping structure for table kitchen_tracker.work_assignments
DROP TABLE IF EXISTS `work_assignments`;
CREATE TABLE IF NOT EXISTS `work_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `project_fitting_item_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `team_leader_id` bigint unsigned NOT NULL,
  `fitting_type_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `standard_time` int NOT NULL,
  `assigned_date` date NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_assignments_project_id_foreign` (`project_id`),
  KEY `work_assignments_project_fitting_item_id_foreign` (`project_fitting_item_id`),
  KEY `work_assignments_employee_id_foreign` (`employee_id`),
  KEY `work_assignments_team_leader_id_foreign` (`team_leader_id`),
  KEY `work_assignments_fitting_type_id_foreign` (`fitting_type_id`),
  CONSTRAINT `work_assignments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_assignments_fitting_type_id_foreign` FOREIGN KEY (`fitting_type_id`) REFERENCES `fitting_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_assignments_project_fitting_item_id_foreign` FOREIGN KEY (`project_fitting_item_id`) REFERENCES `project_fitting_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_assignments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_assignments_team_leader_id_foreign` FOREIGN KEY (`team_leader_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.work_assignments: ~6 rows (approximately)
INSERT INTO `work_assignments` (`id`, `project_id`, `project_fitting_item_id`, `employee_id`, `team_leader_id`, `fitting_type_id`, `quantity`, `standard_time`, `assigned_date`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 2, 3, 2, 1, 11, 1, 20, '2026-10-09', 'completed', 'be carefull', '2026-10-09 00:38:27', '2026-10-09 18:27:51', NULL),
	(2, 2, 3, 2, 1, 11, 1, 20, '2026-10-09', 'pending', NULL, '2026-10-09 18:15:48', '2026-10-14 20:19:30', '2026-10-14 20:19:30'),
	(3, 3, 5, 5, 4, 2, 1, 30, '2026-10-15', 'completed', NULL, '2026-10-14 21:19:32', '2026-10-14 21:25:02', NULL),
	(4, 4, 7, 7, 6, 41, 1, 60, '2026-11-11', 'completed', 'Testingg', '2026-11-11 15:05:44', '2026-11-11 17:22:27', NULL),
	(5, 5, 9, 8, 6, 25, 1, 60, '2026-11-12', 'completed', NULL, '2026-11-12 12:11:04', '2026-11-12 13:40:32', NULL),
	(6, 6, 13, 7, 6, 42, 1, 30, '2026-11-12', 'completed', NULL, '2026-11-12 15:59:05', '2026-11-12 16:57:38', NULL);

-- Dumping structure for table kitchen_tracker.work_logs
DROP TABLE IF EXISTS `work_logs`;
CREATE TABLE IF NOT EXISTS `work_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `work_assignment_id` bigint unsigned NOT NULL,
  `employee_id` bigint unsigned NOT NULL,
  `project_id` bigint unsigned NOT NULL,
  `fitting_type_id` bigint unsigned NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `actual_time` int DEFAULT NULL,
  `standard_time` int NOT NULL,
  `variance` int DEFAULT NULL,
  `efficiency` decimal(8,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('started','paused','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'started',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_logs_work_assignment_id_foreign` (`work_assignment_id`),
  KEY `work_logs_employee_id_foreign` (`employee_id`),
  KEY `work_logs_project_id_foreign` (`project_id`),
  KEY `work_logs_fitting_type_id_foreign` (`fitting_type_id`),
  CONSTRAINT `work_logs_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_logs_fitting_type_id_foreign` FOREIGN KEY (`fitting_type_id`) REFERENCES `fitting_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_logs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_logs_work_assignment_id_foreign` FOREIGN KEY (`work_assignment_id`) REFERENCES `work_assignments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table kitchen_tracker.work_logs: ~5 rows (approximately)
INSERT INTO `work_logs` (`id`, `work_assignment_id`, `employee_id`, `project_id`, `fitting_type_id`, `start_time`, `end_time`, `actual_time`, `standard_time`, `variance`, `efficiency`, `notes`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 2, 11, '2026-10-09 00:39:00', '2026-10-09 18:27:51', 1, 20, -19, 2000.00, NULL, 'completed', '2026-10-09 00:39:00', '2026-10-09 18:27:51'),
	(2, 3, 5, 3, 2, '2026-10-14 21:19:48', '2026-10-14 21:25:02', 1, 30, -29, 3000.00, NULL, 'completed', '2026-10-14 21:19:48', '2026-10-14 21:25:02'),
	(3, 4, 7, 4, 41, '2026-11-11 15:05:58', '2026-11-11 17:22:26', 1, 60, -59, 999.90, NULL, 'completed', '2026-11-11 15:05:58', '2026-11-11 17:22:26'),
	(4, 5, 8, 5, 25, '2026-11-12 12:11:10', '2026-11-12 13:40:32', 1, 60, -59, 999.90, NULL, 'completed', '2026-11-12 12:11:10', '2026-11-12 13:40:32'),
	(5, 6, 7, 6, 42, '2026-11-12 15:59:14', '2026-11-12 16:57:38', 58, 30, 28, 51.70, NULL, 'completed', '2026-11-12 15:59:14', '2026-11-12 16:57:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
