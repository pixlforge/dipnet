# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17-0ubuntu0.16.04.1)
# Database: dipnet
# Generation Time: 2017-11-05 11:24:59 +0000
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
  `description` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('impression','option') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_reference_unique` (`reference`),
  KEY `articles_category_id_foreign` (`category_id`),
  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;

INSERT INTO `articles` (`id`, `reference`, `description`, `type`, `category_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'61550533','NB - A4 - Papier','impression',NULL,'2017-11-05 00:54:33','2017-11-05 00:54:33',NULL),
	(2,'34157491','Vernis UV','option',NULL,'2017-11-05 00:54:33','2017-11-05 00:54:33',NULL),
	(3,'87400985','Reliure Wiro','option',NULL,'2017-11-05 00:54:33','2017-11-05 00:54:33',NULL);

/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table avatars
# ------------------------------------------------------------

DROP TABLE IF EXISTS `avatars`;

CREATE TABLE `avatars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table businesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `businesses`;

CREATE TABLE `businesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `businesses_reference_unique` (`reference`),
  KEY `businesses_company_id_foreign` (`company_id`),
  KEY `businesses_contact_id_foreign` (`contact_id`),
  CONSTRAINT `businesses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `businesses_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `businesses` WRITE;
/*!40000 ALTER TABLE `businesses` DISABLE KEYS */;

INSERT INTO `businesses` (`id`, `name`, `reference`, `description`, `company_id`, `contact_id`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Fête du Slip','35870664','La fameuse Fête du Slip de Delémont',1,1,'Célien','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(2,'Fête du Chihuahua','81367256','Rien à voir avec DJ Bobo',1,2,'Célien','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(3,'Fête des Vendanges','9912562','Le rendez-vous des saoûlards',2,3,'Radu','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(4,'Foire du Valais','99295847','Un autre rendez-vous pour saoûlards',2,4,'Radu','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL);

/*!40000 ALTER TABLE `businesses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('temporaire','permanent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'temporaire',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companies_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;

INSERT INTO `companies` (`id`, `name`, `status`, `description`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Pixlforge','permanent','Agence de développement web','Célien','2017-11-05 00:54:33','2017-11-05 00:54:33',NULL),
	(2,'Bebold','permanent','Agence de développement Web','Radu','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL);

/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_user_id_foreign` (`user_id`),
  KEY `contacts_company_id_foreign` (`company_id`),
  KEY `contacts_name_index` (`name`),
  CONSTRAINT `contacts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `phone_number`, `fax`, `email`, `user_id`, `company_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Borbet','Le Borbet 23','App 19','2950','Courgenay','+41 (0)78 687 31 97','+7004788963822','celien@pixlforge.ch',1,1,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(2,'Genévrier','Le Genévrier 2','App 2','2950','Courgenay','+41 (0)32 471 30 14','+3955825671447','celien@pixlforge.ch',1,1,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(3,'Lausanne','Le Flon','125 Torrance Vista','1003','Lausanne','+41 (0)78 123 45 67','+1750804328941','radu@bebold.ch',2,2,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(4,'Martigny','Avenue de la Poste','1639 Houston Rest','1920','Martigny','+41 (0)78 123 45 67','+4816853335326','radu@bebold.ch',2,2,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL);

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table deliveries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deliveries`;

CREATE TABLE `deliveries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `order_id` int(10) unsigned DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `deliveries_reference_unique` (`reference`),
  KEY `deliveries_order_id_foreign` (`order_id`),
  KEY `deliveries_contact_id_foreign` (`contact_id`),
  CONSTRAINT `deliveries_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `deliveries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;

INSERT INTO `deliveries` (`id`, `reference`, `note`, `order_id`, `contact_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'159fe5346e85e6',NULL,1,1,'2017-11-05 00:54:46','2017-11-05 10:36:33',NULL),
	(10,'159fef235932f9',NULL,1,2,'2017-11-05 12:12:53','2017-11-05 12:12:58',NULL);

/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table documents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint(20) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `finish` enum('roulé','plié') COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_id` int(10) unsigned DEFAULT NULL,
  `delivery_id` int(10) unsigned DEFAULT NULL,
  `article_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_format_id_foreign` (`format_id`),
  KEY `documents_delivery_id_foreign` (`delivery_id`),
  KEY `documents_article_id_foreign` (`article_id`),
  KEY `documents_filename_index` (`filename`),
  CONSTRAINT `documents_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documents_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documents_format_id_foreign` FOREIGN KEY (`format_id`) REFERENCES `formats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;

INSERT INTO `documents` (`id`, `filename`, `mime_type`, `size`, `quantity`, `finish`, `format_id`, `delivery_id`, `article_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'portrait05.jpg','image/jpeg',18701,NULL,'roulé',NULL,1,NULL,'2017-11-05 01:04:56','2017-11-05 01:04:56',NULL),
	(2,'celien-boillat-cv.pdf','application/pdf',121922,NULL,'roulé',NULL,1,NULL,'2017-11-05 01:12:19','2017-11-05 01:12:19',NULL),
	(3,'PEQ.pdf','application/pdf',177207,NULL,'roulé',NULL,NULL,NULL,'2017-11-05 12:10:40','2017-11-05 12:10:40',NULL);

/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table formats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `formats`;

CREATE TABLE `formats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `surface` decimal(12,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `formats_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `formats` WRITE;
/*!40000 ALTER TABLE `formats` DISABLE KEYS */;

INSERT INTO `formats` (`id`, `name`, `height`, `width`, `surface`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'jacobson',89,86,7551.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(2,'leannon',22,96,1655.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(3,'williamson',82,19,1184.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(4,'corwin',71,49,6233.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(5,'larkin',21,26,6294.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(6,'gleichner',81,76,9278.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(7,'goodwin',66,6,9581.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(8,'marquardt',12,16,896.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(9,'shanahan',29,47,3475.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL),
	(10,'koelpin',78,86,8930.0000,'2017-11-05 00:54:34','2017-11-05 00:54:34',NULL);

/*!40000 ALTER TABLE `formats` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invitations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invitations`;

CREATE TABLE `invitations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitations_email_unique` (`email`),
  UNIQUE KEY `invitations_token_unique` (`token`),
  KEY `invitations_company_id_foreign` (`company_id`),
  CONSTRAINT `invitations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
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
	(1,'2014_10_12_100000_create_password_resets_table',1),
	(2,'2017_05_09_172315_create_companies_table',1),
	(3,'2017_05_09_173408_create_users_table',1),
	(4,'2017_05_09_173409_create_contacts_table',1),
	(5,'2017_05_09_173410_create_businesses_table',1),
	(6,'2017_05_09_185357_create_orders_table',1),
	(7,'2017_05_10_084559_create_formats_table',1),
	(8,'2017_05_10_085200_create_categories_table',1),
	(9,'2017_05_10_085535_create_articles_table',1),
	(10,'2017_05_10_142429_create_deliveries_table',1),
	(11,'2017_05_10_142440_create_documents_table',1),
	(12,'2017_10_02_204145_create_invitations_table',1),
	(13,'2017_10_11_154902_add_avatar_id_to_users_table',1),
	(14,'2017_10_11_155258_create_avatars_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('incomplete','pending','shipped','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'incomplete',
  `business_id` int(10) unsigned DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_reference_unique` (`reference`),
  KEY `orders_business_id_foreign` (`business_id`),
  KEY `orders_contact_id_foreign` (`contact_id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `reference`, `status`, `business_id`, `contact_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'159fe5345eb9d6','incomplete',1,2,1,'2017-11-05 00:54:45','2017-11-05 12:12:57',NULL),
	(2,'159fef0f5a4bfd','incomplete',NULL,NULL,1,'2017-11-05 12:07:33','2017-11-05 12:07:33',NULL),
	(3,'159fef1a8ea9c9','incomplete',NULL,NULL,1,'2017-11-05 12:10:32','2017-11-05 12:10:32',NULL);

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;


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
  `role` enum('utilisateur','administrateur') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'utilisateur',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `contact_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `company_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `avatar_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_confirmation_token_unique` (`confirmation_token`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `company_id`, `email_confirmed`, `contact_confirmed`, `company_confirmed`, `confirmation_token`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `avatar_id`)
VALUES
	(1,'Célien','$2y$10$OtTxga0w0zV5yPWSoFNfK.T57xowAn25TntVrZ7J3FC6hIbHz357m','administrateur','celien@pixlforge.ch',1,1,1,1,'e6080e5f9c1e46fffd21f6c953f3fa27','jQoGFb177K','2017-11-05 00:54:33','2017-11-05 00:54:33',NULL,NULL),
	(2,'Radu','$2y$10$gO4BJPEaMZq0dw9WYdf1.e1NwyGjmJyQmE4W0cBswa30clJZQw6t.','administrateur','radu@bebold.ch',2,1,1,1,'1199e4e39ba4657c96e7c156c380aa8d','qODi65u6Pb','2017-11-05 00:54:34','2017-11-05 00:54:34',NULL,NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
