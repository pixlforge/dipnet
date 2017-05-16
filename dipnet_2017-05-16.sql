# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17-0ubuntu0.16.04.1)
# Database: dipnet
# Generation Time: 2017-05-16 12:13:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table articles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_web` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_dip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_printing` tinyint(4) NOT NULL,
  `public` tinyint(4) NOT NULL,
  `consumable` tinyint(4) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `price_m2` int(11) DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `extra_rate_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_reference_unique` (`reference`),
  KEY `articles_category_id_foreign` (`category_id`),
  KEY `articles_extra_rate_id_foreign` (`extra_rate_id`),
  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `articles_extra_rate_id_foreign` FOREIGN KEY (`extra_rate_id`) REFERENCES `extra_rates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table business_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `business_comments`;

CREATE TABLE `business_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` int(10) unsigned NOT NULL,
  `created_by_user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `business_comments_business_id_foreign` (`business_id`),
  KEY `business_comments_created_by_user_id_foreign` (`created_by_user_id`),
  CONSTRAINT `business_comments_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`),
  CONSTRAINT `business_comments_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table businesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `businesses`;

CREATE TABLE `businesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `main_contact_id` int(10) unsigned NOT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `businesses_company_id_foreign` (`company_id`),
  KEY `businesses_main_contact_id_foreign` (`main_contact_id`),
  CONSTRAINT `businesses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `businesses_main_contact_id_foreign` FOREIGN KEY (`main_contact_id`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `reference_contact_id` int(10) unsigned DEFAULT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_company_id_foreign` (`company_id`),
  CONSTRAINT `contacts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table deliveries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deliveries`;

CREATE TABLE `deliveries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `delivery_contact_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deliveries_order_id_foreign` (`order_id`),
  KEY `deliveries_delivery_contact_id_foreign` (`delivery_contact_id`),
  CONSTRAINT `deliveries_delivery_contact_id_foreign` FOREIGN KEY (`delivery_contact_id`) REFERENCES `contacts` (`id`),
  CONSTRAINT `deliveries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table delivery_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `delivery_comments`;

CREATE TABLE `delivery_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_id` int(10) unsigned NOT NULL,
  `created_by_user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `delivery_comments_delivery_id_foreign` (`delivery_id`),
  KEY `delivery_comments_created_by_user_id_foreign` (`created_by_user_id`),
  CONSTRAINT `delivery_comments_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `delivery_comments_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table documents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `rolled_folded_flat` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `nb_orig` int(11) NOT NULL,
  `free` tinyint(4) NOT NULL,
  `format_id` int(10) unsigned NOT NULL,
  `delivery_id` int(10) unsigned NOT NULL,
  `main_article_id` int(10) unsigned NOT NULL,
  `option_article_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_format_id_foreign` (`format_id`),
  KEY `documents_delivery_id_foreign` (`delivery_id`),
  KEY `documents_main_article_id_foreign` (`main_article_id`),
  CONSTRAINT `documents_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  CONSTRAINT `documents_format_id_foreign` FOREIGN KEY (`format_id`) REFERENCES `formats` (`id`),
  CONSTRAINT `documents_main_article_id_foreign` FOREIGN KEY (`main_article_id`) REFERENCES `articles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table extra_rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `extra_rates`;

CREATE TABLE `extra_rates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table formats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `formats`;

CREATE TABLE `formats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `surface` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `formats_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(89,'2014_10_12_000000_create_users_table',1),
	(90,'2014_10_12_100000_create_password_resets_table',1),
	(91,'2017_05_09_163758_create_businesses_table',1),
	(92,'2017_05_09_172315_create_companies_table',1),
	(93,'2017_05_09_173405_create_contacts_table',1),
	(94,'2017_05_09_185357_create_orders_table',1),
	(95,'2017_05_10_084559_create_formats_table',1),
	(96,'2017_05_10_085200_create_categories_table',1),
	(97,'2017_05_10_085405_create_extra_rates_table',1),
	(98,'2017_05_10_085535_create_articles_table',1),
	(99,'2017_05_10_090336_create_documents_table',1),
	(100,'2017_05_10_141954_create_business_comments_table',1),
	(101,'2017_05_10_142209_create_delivery_comments_table',1),
	(102,'2017_05_10_142429_create_deliveries_table',1),
	(103,'2017_05_10_145628_add_foreign_keys_articles_table',1),
	(104,'2017_05_10_163217_add_foreign_keys_business_comments_table',1),
	(105,'2017_05_10_164835_add_foreign_keys_businesses_table',1),
	(106,'2017_05_10_165804_add_foreign_keys_contacts_table',1),
	(107,'2017_05_10_172845_add_foreign_keys_deliveries_table',1),
	(108,'2017_05_10_173205_add_foreign_keys_delivery_comments_table',1),
	(109,'2017_05_10_173543_add_foreign_keys_documents_table',1),
	(110,'2017_05_10_181450_add_foreign_keys_orders_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_id` int(10) unsigned NOT NULL,
  `billing_contact_id` int(10) unsigned NOT NULL,
  `created_by_user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_reference_unique` (`reference`),
  KEY `orders_business_id_foreign` (`business_id`),
  KEY `orders_billing_contact_id_foreign` (`billing_contact_id`),
  KEY `orders_created_by_user_id_foreign` (`created_by_user_id`),
  CONSTRAINT `orders_billing_contact_id_foreign` FOREIGN KEY (`billing_contact_id`) REFERENCES `contacts` (`id`),
  CONSTRAINT `orders_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`),
  CONSTRAINT `orders_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_validated` tinyint(4) NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
