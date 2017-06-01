# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17-0ubuntu0.16.04.1)
# Database: dipnet
# Generation Time: 2017-06-01 19:00:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table article_document
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article_document`;

CREATE TABLE `article_document` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_document_document_id_foreign` (`document_id`),
  KEY `article_document_article_id_foreign` (`article_id`),
  CONSTRAINT `article_document_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `article_document_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table articles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('impression','option') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
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
	(1,'96389183',NULL,'impression',1,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(2,'50519205',NULL,'option',2,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(3,'27893656',NULL,'impression',3,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(4,'99429678',NULL,'option',4,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(5,'44706476',NULL,'option',5,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `business_comments` WRITE;
/*!40000 ALTER TABLE `business_comments` DISABLE KEYS */;

INSERT INTO `business_comments` (`id`, `content`, `business_id`, `created_by_user_id`, `created_at`, `updated_at`)
VALUES
	(1,'Quia eos perspiciatis eius fugit. Perspiciatis doloremque voluptatum repellendus dignissimos ex ut ut quia. Quis aperiam eveniet eligendi. Non debitis esse non eos nam ipsam.',1,2,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(2,'Et nisi occaecati sed adipisci nisi rerum earum necessitatibus. At vero aut et et magni sed dolorem. Et sit autem dolores nihil iste voluptate porro.',2,4,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(3,'Nisi rem incidunt nam. Ut hic nobis rerum rerum quis a. Alias eaque tenetur omnis molestias tempora repellat expedita. Vel omnis adipisci officiis eveniet aut totam.',3,6,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(4,'Dolorem quaerat molestiae sint culpa tenetur. Exercitationem recusandae at ad et voluptatem sed. Aut perspiciatis dolor dolor enim sequi enim. Numquam velit est laudantium nobis optio repellat.',4,8,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(5,'Blanditiis officia velit voluptatem. Omnis voluptas maiores vitae perspiciatis ducimus. Tempora ipsam facilis facilis voluptates ducimus est. Qui ducimus qui debitis. Adipisci molestias quibusdam ut vitae sint exercitationem.',5,10,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(6,'Ea ratione velit architecto qui nisi et quidem. Ullam soluta id numquam sint ratione itaque a. Nulla quisquam consequuntur est temporibus sed non quibusdam. Dolor mollitia ab quis odio non quo.',6,12,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(7,'Et earum voluptatibus magnam soluta veniam expedita. Necessitatibus reiciendis ea quasi provident deserunt est tenetur. Aspernatur soluta quibusdam consequuntur quis ea.',7,14,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(8,'Deleniti recusandae est tempora exercitationem natus impedit in. Suscipit perspiciatis officia fugiat saepe mollitia. Tenetur dolores aut facilis aut vero. Ut dolorem et unde numquam est.',8,16,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(9,'Quibusdam sed ipsa non voluptates voluptatem. Iusto sequi sit sint ut. Iure blanditiis sit quaerat voluptatem iusto fuga.',9,18,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(10,'Eaque ea dolor in porro quo quasi quia odit. Rerum dolorem illum dolores veniam quisquam nihil nihil. Culpa laudantium voluptates quia eum. Quo excepturi reiciendis quaerat aliquam voluptatem.',10,20,'2017-06-01 18:57:11','2017-06-01 18:57:11');

/*!40000 ALTER TABLE `business_comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table businesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `businesses`;

CREATE TABLE `businesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `main_contact_id` int(10) unsigned DEFAULT NULL,
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

LOCK TABLES `businesses` WRITE;
/*!40000 ALTER TABLE `businesses` DISABLE KEYS */;

INSERT INTO `businesses` (`id`, `name`, `reference`, `description`, `company_id`, `main_contact_id`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Deckow Group','94646888','Business-focused human-resource capacity',1,1,'1','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(2,'Predovic-Lesch','49659236','Multi-tiered bi-directional help-desk',5,2,'3','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(3,'Leannon Group','17137922','Visionary user-facing website',9,3,'5','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(4,'Prosacco and Sons','65516807','Down-sized encompassing encryption',13,4,'7','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(5,'Streich Group','98735229','Ergonomic methodical extranet',17,5,'9','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(6,'Rosenbaum, Lubowitz and Schiller','58972695','Optional full-range budgetarymanagement',21,6,'11','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(7,'Toy, Hamill and Gibson','92337687','Switchable logistical framework',25,7,'13','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(8,'Fadel and Sons','11163671','Cloned composite challenge',29,8,'15','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(9,'Franecki LLC','61339859','Grass-roots executive strategy',33,9,'17','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(10,'Mueller-Jacobs','84675349','Facetoface foreground project',37,10,'19','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(11,'Lockman-Bartell','70484322','Profit-focused assymetric migration',41,11,'21','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(12,'Toy Inc','98480330','Open-source foreground contingency',48,14,'24','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(13,'King Group','70655862','Grass-roots needs-based strategy',55,17,'27','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(14,'Mayert Inc','62901092','Quality-focused content-based budgetarymanagement',62,20,'30','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(15,'Franecki, Mills and Wisoky','30688420','Visionary attitude-oriented database',69,23,'33','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(16,'Schimmel-Ullrich','47343597','Enhanced exuding info-mediaries',76,26,'36','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(17,'Mann-Sauer','58494391','Phased real-time neural-net',83,29,'39','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(18,'Leffler, Heathcote and Mayer','92047265','Vision-oriented solution-oriented installation',90,32,'42','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(19,'Koss-Brekke','99996849','Implemented user-facing algorithm',97,35,'45','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(20,'Lebsack, Konopelski and McCullough','22748685','Optimized tangible access',104,38,'48','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(21,'Carroll and Sons','59258236','Profound background hub',111,41,'51','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(22,'Pouros, Gulgowski and Parisian','82910150','Diverse asynchronous securedline',117,44,'53','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(23,'Jacobs-Kerluke','90132500','Function-based systemic projection',123,47,'55','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(24,'Kozey-Schimmel','28693144','De-engineered stable capacity',129,50,'57','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(25,'Lakin Group','87548435','Pre-emptive analyzing encryption',135,53,'59','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Orchid','2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(2,'DarkViolet','2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(3,'PapayaWhip','2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(4,'Linen','2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(5,'Tan','2017-06-01 18:57:11','2017-06-01 18:57:11');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companies_contact_id_foreign` (`contact_id`),
  CONSTRAINT `companies_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;

INSERT INTO `companies` (`id`, `name`, `status`, `description`, `contact_id`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Stark-Bins','ok','Synergistic dynamic parallelism',NULL,'elinore.deckow','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(2,'Blick-Gleichner','nok','Re-engineered contextually-based success',NULL,'turner27','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(3,'Okuneva, Gusikowski and Gerhold','nok','Operative tangible emulation',NULL,'ysimonis','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(4,'Wisoky-Muller','nok','Automated logistical definition',NULL,'ihackett','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(5,'Kautzer PLC','ok','Grass-roots leadingedge protocol',NULL,'bechtelar.odie','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(6,'Hamill-O\'Reilly','ok','Business-focused secondary protocol',NULL,'johanna.wintheiser','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(7,'Rowe Inc','nok','Optimized uniform algorithm',NULL,'leanne06','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(8,'Hermiston, Cole and Lakin','ok','Open-source methodical securedline',NULL,'garnet.spinka','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(9,'McClure-Heller','ok','Mandatory empowering frame',NULL,'morar.lynn','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(10,'Feest, Will and Crist','nok','Exclusive logistical framework',NULL,'nader.javonte','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(11,'Zboncak, Denesik and Dare','ok','Optional needs-based help-desk',NULL,'osipes','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(12,'Macejkovic Inc','ok','Organic exuding installation',NULL,'heidenreich.shanna','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(13,'Cummerata, Kerluke and Macejkovic','nok','Compatible grid-enabled analyzer',NULL,'miller.cornell','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(14,'Cartwright-Gutkowski','nok','Versatile neutral middleware',NULL,'jenkins.pattie','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(15,'Larson, Torphy and Bradtke','ok','Synchronised bi-directional functionalities',NULL,'zion92','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(16,'Adams, O\'Conner and Senger','ok','Total cohesive website',NULL,'camden10','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(17,'Stark Inc','nok','Realigned web-enabled info-mediaries',NULL,'aidan14','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(18,'Kirlin, Boyer and Dickinson','ok','Diverse real-time data-warehouse',NULL,'maynard.mills','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(19,'Sauer Group','nok','Optimized uniform matrices',NULL,'ross59','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(20,'Spencer Ltd','nok','Enterprise-wide clear-thinking orchestration',NULL,'tiara.herzog','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(21,'Bosco-Daugherty','ok','Exclusive eco-centric success',NULL,'collins.julie','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(22,'Bradtke-Champlin','nok','Decentralized attitude-oriented neural-net',NULL,'herminio69','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(23,'Moore Ltd','ok','Configurable value-added collaboration',NULL,'dstreich','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(24,'Effertz-Rogahn','nok','Horizontal executive complexity',NULL,'roslyn88','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(25,'Fay-Connelly','ok','Streamlined directional groupware',NULL,'smith.mallie','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(26,'Runte, Koepp and Nolan','nok','Ameliorated solution-oriented product',NULL,'tromp.valentine','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(27,'Douglas, Moen and Carroll','nok','Persevering full-range monitoring',NULL,'tillman.ryley','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(28,'Brakus-Mertz','ok','Enhanced analyzing frame',NULL,'geoffrey.wuckert','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(29,'Batz and Sons','ok','Synergistic bifurcated portal',NULL,'lpfeffer','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(30,'Koss-Kreiger','ok','User-centric systematic synergy',NULL,'alda38','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(31,'Kilback, Nitzsche and Streich','ok','Enhanced 4thgeneration definition',NULL,'skiles.keshaun','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(32,'Kiehn, Sauer and Carter','ok','User-friendly systematic solution',NULL,'annette.boyer','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(33,'Cormier-Mills','ok','Synchronised methodical access',NULL,'gboyer','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(34,'Cruickshank, Kerluke and Hand','nok','Programmable zerotolerance focusgroup',NULL,'narciso.treutel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(35,'Stoltenberg-Okuneva','ok','Realigned cohesive instructionset',NULL,'owhite','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(36,'Koch, Paucek and Effertz','ok','Persevering mission-critical parallelism',NULL,'leopoldo.wintheiser','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(37,'Abshire, Jacobson and Tromp','nok','Enterprise-wide methodical support',NULL,'jerde.jeffry','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(38,'Bradtke LLC','ok','Inverse actuating customerloyalty',NULL,'predovic.zena','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(39,'Wolf Group','ok','Robust bottom-line securedline',NULL,'roberto.torphy','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(40,'Koch-Treutel','ok','Synergized didactic synergy',NULL,'haley.jamaal','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(41,'Wolff, Mueller and Schiller','nok','Digitized uniform software',NULL,'qjacobson','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(42,'Pfannerstill-Durgan','ok','Multi-tiered methodical workforce',NULL,'trobel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(43,'Aufderhar-Gerhold','nok','Advanced bifurcated database',NULL,'jschiller','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(44,'Feil, Carter and Von','nok','Cross-group eco-centric paradigm',NULL,'richie60','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(45,'Borer LLC','ok','Profound even-keeled projection',NULL,'juvenal.gulgowski','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(46,'Grant Inc','nok','Self-enabling demand-driven instructionset',NULL,'arjun30','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(47,'Miller-Weimann','nok','Proactive exuding help-desk',NULL,'max06','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(48,'Tremblay, Altenwerth and Lesch','ok','Proactive encompassing frame',NULL,'schamberger.broderick','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(49,'Muller, Friesen and Schimmel','ok','Up-sized responsive adapter',NULL,'brooke44','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(50,'Johnston-Goyette','ok','Implemented non-volatile forecast',NULL,'audrey68','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(51,'Kerluke, Kerluke and Altenwerth','nok','Balanced coherent knowledgebase',NULL,'corwin.ansley','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(52,'Rowe, Rodriguez and Gusikowski','ok','Synergistic zeroadministration time-frame',NULL,'ddouglas','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(53,'Bergstrom Inc','nok','Switchable multimedia securedline',NULL,'tod.blanda','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(54,'Jacobson Inc','nok','Pre-emptive background collaboration',NULL,'murphy.onie','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(55,'Lemke and Sons','nok','Persevering empowering database',NULL,'ccorwin','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(56,'Schoen, Leuschke and Bins','ok','Phased executive knowledgebase',NULL,'brannon95','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(57,'Hirthe, Jacobi and Feest','ok','Seamless client-driven alliance',NULL,'luettgen.luigi','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(58,'Powlowski-Hoppe','nok','Polarised radical archive',NULL,'blanda.adolph','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(59,'Zemlak-Harber','ok','Profit-focused transitional solution',NULL,'iswaniawski','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(60,'Volkman, Jacobs and Gleichner','nok','Enterprise-wide client-driven utilisation',NULL,'vreynolds','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(61,'Kilback, Little and Mann','nok','Secured mobile benchmark',NULL,'glenna.lowe','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(62,'Spinka-Windler','ok','Networked contextually-based task-force',NULL,'fdietrich','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(63,'Bartoletti, Blick and Beahan','ok','Versatile exuding framework',NULL,'boehm.chloe','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(64,'Greenholt, Wilkinson and Wilderman','nok','Reduced composite archive',NULL,'ignatius.schimmel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(65,'West-Cruickshank','nok','Automated reciprocal structure',NULL,'barton.shyanne','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(66,'Champlin, Kuhn and Runolfsdottir','nok','Profit-focused explicit function',NULL,'quitzon.rosa','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(67,'Schuster LLC','ok','Fully-configurable 6thgeneration implementation',NULL,'luella68','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(68,'Murray Group','nok','Total motivating architecture',NULL,'candido23','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(69,'Stanton, Schowalter and Buckridge','nok','Visionary background hub',NULL,'arlene73','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(70,'Durgan, Gerhold and Corkery','nok','Configurable disintermediate benchmark',NULL,'raina.kessler','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(71,'Flatley PLC','ok','Open-source national access',NULL,'feil.shanel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(72,'Ullrich, Monahan and Gulgowski','ok','Mandatory secondary extranet',NULL,'ofritsch','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(73,'Wunsch Inc','ok','Programmable dedicated paradigm',NULL,'shanahan.hollie','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(74,'Daugherty PLC','nok','Programmable multi-state instructionset',NULL,'donna12','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(75,'Ferry, Zemlak and Waelchi','nok','Innovative full-range migration',NULL,'zschaden','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(76,'Auer, Kub and Bednar','ok','Upgradable motivating approach',NULL,'destiny57','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(77,'Dickens Inc','ok','Open-architected fresh-thinking knowledgebase',NULL,'ferdman','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(78,'Weissnat, Maggio and Carter','ok','Sharable bifurcated middleware',NULL,'deichmann','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(79,'Goldner-Murray','ok','Stand-alone client-driven artificialintelligence',NULL,'emmy89','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(80,'Goodwin Ltd','ok','Versatile demand-driven utilisation',NULL,'hickle.alford','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(81,'Effertz, Gusikowski and Kunde','ok','Programmable zeroadministration projection',NULL,'frau','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(82,'Gusikowski Group','ok','Total reciprocal synergy',NULL,'lherman','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(83,'Becker, Rogahn and Johns','ok','Team-oriented needs-based capability',NULL,'ruthie56','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(84,'Stroman PLC','ok','Polarised fresh-thinking moderator',NULL,'chaim38','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(85,'Zieme PLC','nok','Fundamental 4thgeneration protocol',NULL,'alberto13','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(86,'Kuphal-Wolf','ok','Automated mission-critical standardization',NULL,'devin.johnston','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(87,'Orn, Swaniawski and Feeney','ok','Networked maximized definition',NULL,'kabshire','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(88,'Shanahan and Sons','nok','Open-architected optimal paradigm',NULL,'koelpin.thad','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(89,'Stracke-Jakubowski','nok','Down-sized impactful securedline',NULL,'parisian.helene','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(90,'Haag-Sipes','nok','Decentralized disintermediate infrastructure',NULL,'trinity.rau','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(91,'Koelpin Inc','nok','Integrated global complexity',NULL,'welch.keely','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(92,'Murray, Maggio and Wunsch','nok','Cross-platform mobile model',NULL,'skunze','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(93,'Franecki and Sons','nok','Upgradable methodical frame',NULL,'nash86','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(94,'Moen LLC','ok','Networked composite analyzer',NULL,'ben32','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(95,'Wehner, Raynor and Kunde','nok','Team-oriented foreground conglomeration',NULL,'jbrakus','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(96,'Gaylord-Macejkovic','ok','Customizable scalable infrastructure',NULL,'uwill','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(97,'Welch, Lowe and Nicolas','nok','Networked context-sensitive hub',NULL,'zkulas','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(98,'Fritsch and Sons','nok','Stand-alone multi-state conglomeration',NULL,'orohan','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(99,'Waters-Grant','nok','Future-proofed incremental installation',NULL,'qtillman','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(100,'Moen Ltd','nok','Team-oriented homogeneous strategy',NULL,'zachery97','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(101,'Wintheiser, Breitenberg and Ferry','nok','Decentralized even-keeled task-force',NULL,'aschamberger','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(102,'West-Zulauf','nok','Optimized intangible solution',NULL,'vrau','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(103,'Maggio-Zboncak','nok','Polarised well-modulated knowledgebase',NULL,'brionna71','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(104,'Braun-Sawayn','ok','Object-based contextually-based service-desk',NULL,'eveline39','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(105,'Zboncak-Harris','ok','Automated web-enabled utilisation',NULL,'vconnelly','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(106,'Heathcote-Fahey','ok','Vision-oriented stable processimprovement',NULL,'aron.bosco','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(107,'Kreiger, Nolan and Boyer','nok','Ergonomic intermediate GraphicInterface',NULL,'eino.friesen','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(108,'Collier Inc','ok','Operative web-enabled task-force',NULL,'cali.considine','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(109,'Pfannerstill Group','ok','Digitized modular encoding',NULL,'gorczany.brown','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(110,'Littel, Miller and Roberts','nok','Enterprise-wide fault-tolerant intranet',NULL,'jdenesik','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(111,'Kuvalis Ltd','nok','Balanced client-server definition',NULL,'gerlach.jeramy','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(112,'Frami-Crist','nok','Cross-platform uniform protocol',NULL,'jacobson.thelma','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(113,'Schimmel-Nader','nok','Robust analyzing success',NULL,'rosamond.renner','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(114,'Watsica-Treutel','nok','Facetoface stable throughput',NULL,'cornell88','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(115,'Schiller-Baumbach','ok','Profound static support',NULL,'jamil.nicolas','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(116,'Schmeler Ltd','nok','Automated secondary analyzer',NULL,'lbruen','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(117,'Kiehn-Effertz','ok','Reverse-engineered bandwidth-monitored access',NULL,'evalyn.romaguera','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(118,'Hermiston-Lang','ok','Public-key content-based function',NULL,'jewell.herman','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(119,'Kuphal Group','nok','Secured systemic systemengine',NULL,'lshanahan','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(120,'Metz Inc','nok','Vision-oriented regional functionalities',NULL,'larson.elwin','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(121,'Cummings-Stanton','nok','Optional intermediate utilisation',NULL,'stoltenberg.miracle','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(122,'Zemlak-Trantow','nok','Extended regional attitude',NULL,'stephanie.adams','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(123,'Wolf, Grimes and Kunze','nok','Ameliorated mission-critical challenge',NULL,'phyllis02','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(124,'Barton-Ernser','nok','Assimilated holistic encoding',NULL,'dena.legros','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(125,'Medhurst Inc','nok','Managed real-time extranet',NULL,'xbrown','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(126,'Williamson-O\'Reilly','ok','Customizable optimal challenge',NULL,'xfeest','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(127,'Jacobs Ltd','nok','Polarised incremental adapter',NULL,'kuhlman.anabel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(128,'Oberbrunner LLC','ok','Configurable solution-oriented time-frame',NULL,'lennie.harvey','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(129,'Nolan, Emmerich and Hirthe','ok','Business-focused bandwidth-monitored extranet',NULL,'larkin.mara','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(130,'Gutmann Inc','ok','Multi-lateral homogeneous intranet',NULL,'nicolette.mosciski','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(131,'Baumbach, Dicki and Pfannerstill','ok','Phased real-time structure',NULL,'abecker','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(132,'Prosacco LLC','ok','Facetoface 6thgeneration policy',NULL,'kbahringer','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(133,'Bogisich-Walter','nok','Multi-channelled discrete functionalities',NULL,'daphney78','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(134,'VonRueden Group','nok','Fundamental secondary hub',NULL,'gene.denesik','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(135,'Stamm and Sons','ok','Centralized tertiary approach',NULL,'effertz.dejah','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(136,'Beer-Kuphal','ok','Re-engineered zerotolerance archive',NULL,'clotilde.swaniawski','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(137,'Crooks PLC','ok','Optimized needs-based benchmark',NULL,'pjast','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(138,'Collier-Nolan','ok','Configurable grid-enabled migration',NULL,'dwiza','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(139,'McClure LLC','nok','Enhanced content-based collaboration',NULL,'emilio72','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(140,'Hettinger, Bogisich and Spencer','nok','Future-proofed zerotolerance flexibility',NULL,'weimann.ivory','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;


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
  `company_id` int(10) unsigned NOT NULL,
  `created_by_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_company_id_foreign` (`company_id`),
  CONSTRAINT `contacts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `phone_number`, `fax`, `email`, `company_id`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'bartoletti','Bergstrom Ridge','1496 Darrel Pass Apt. 537','65714','Lake Reginald','+8765065325732','+0891644422086','kulas.sofia@dare.com',2,'lydia.ortiz','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(2,'rohan','Kulas Rapid','651 Haag Estates Suite 793','44910','Harveyside','+1817045671555','+0527327505215','francesca.murazik@kiehn.com',6,'alexanne.toy','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(3,'waelchi','Rempel Shoal','788 McCullough Plaza','58455','Port Evanside','+1369532820351','+0535182105509','cbeier@murazik.com',10,'plangosh','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(4,'upton','Luettgen Coves','435 Johnson Station Apt. 010','89294','Lake Syblestad','+0700055621203','+0520309253480','rowan37@murazik.com',14,'gabriella.jast','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(5,'gusikowski','Annabel Isle','4149 Veda Courts','31856','Collierton','+2346601008052','+4701784617091','francisca.paucek@rath.com',18,'trystan.hermiston','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(6,'torp','Ola Centers','1137 Troy Village Apt. 784','51783','Predovicland','+6007546072542','+1151191851095','talon.keeling@hilpert.com',22,'greenfelder.larue','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(7,'farrell','Shanon Camp','107 Norris Crossroad','67756','New Grayceview','+5049444657402','+2972446790253','bbeer@stehr.biz',26,'dovie84','2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(8,'torphy','Emmy Forest','5603 Botsford Rest Suite 409','93214','West Demetrius','+1817377843658','+3687087114104','zhodkiewicz@toy.net',30,'ogreenfelder','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(9,'romaguera','Barrows Orchard','82747 Bradley Lane','33996-0690','Blancheburgh','+2541970712264','+5217593450139','isai.harris@thiel.com',34,'droberts','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(10,'conroy','Reichel Islands','761 Buckridge Isle','69875-6045','South Jonathon','+6610127096004','+1218457719934','vjerde@mayer.org',38,'mireille67','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(11,'spinka','Zieme Ridges','52470 Adela Skyway Suite 873','16519-5503','Stromanview','+9423504163540','+4430911139149','jacobson.cruz@zulauf.net',42,'ohara.peggie','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(12,'nicolas','Karine Vista','7959 Schulist Inlet Apt. 193','52918-3195','Cruzhaven','+7110253185194','+3092339385466','adams.heather@monahan.info',44,'jamey99','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(13,'hessel','Nya Drive','87624 Oleta Squares Apt. 330','71986','New Carleeland','+9780401292843','+7832330521117','imani66@kub.info',46,'proberts','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(14,'senger','Braun Light','3914 Bonnie Landing Apt. 181','28277-8743','West Willis','+2200834304260','+4152463421247','friedrich88@lemke.com',49,'witting.natalie','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(15,'pollich','Friedrich Springs','2903 Kris Ferry','09435-6487','Port Loma','+8672532733186','+7972335901119','clark36@mccullough.com',51,'gbartell','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(16,'tremblay','Harmon Curve','7737 Arturo Pine','39124','Taniachester','+1873256582290','+6676589272842','sjakubowski@kohler.com',53,'linnie08','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(17,'farrell','Cloyd Flat','874 Vandervort Crossing','97214','Lake Lorainemouth','+7657994641585','+9203361856091','patience63@becker.com',56,'boyd.mante','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(18,'boyle','Hartmann Dale','4552 Nelson Avenue Apt. 459','34375-3404','Elishastad','+8982396937072','+1273917232640','meggie28@dibbert.com',58,'collins.durward','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(19,'lemke','Daphney Ranch','1000 Hortense Union','20328-7919','South Camilleburgh','+8684600762214','+7136918856795','metz.kaycee@zieme.com',60,'cremin.josh','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(20,'lynch','Oberbrunner Hill','90467 Kiehn Roads','63514-2799','North Demetris','+2038724533653','+7655004027524','letitia44@mohr.net',63,'gkoch','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(21,'ratke','Bartell Heights','1309 Kaelyn Terrace','09309','East Elinor','+4254052502828','+7399243859251','harvey.manley@stiedemann.com',65,'melyssa.mante','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(22,'little','Zieme Shoals','8504 Alva Neck','50159-0309','East Alainastad','+0839224676882','+1800006377126','ruben83@sanford.info',67,'arnold.ankunding','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(23,'torp','Bradtke Forks','5444 Amari Extensions Suite 405','89508','Strosinshire','+0861980083153','+4976658706877','heathcote.eriberto@haley.info',70,'hrath','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(24,'mante','Osinski Bridge','5590 Joesph Inlet','73608','North Sydneyland','+9423119526271','+6290285082076','general04@mohr.org',72,'flittle','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(25,'buckridge','Schimmel Hill','600 Padberg Junctions Suite 910','20907','Kylamouth','+1947083797432','+7891095480892','schulist.aryanna@bogisich.info',74,'everette.oconner','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(26,'stamm','Theresia Island','6783 Robel Radial Apt. 954','84324','Lemuelville','+9108895384973','+0441376110837','dudley.bashirian@macejkovic.biz',77,'karl83','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(27,'huel','Nat Prairie','888 Catharine Estates Suite 359','01842','East Glenda','+2291042693379','+0583398036282','joconnell@feest.com',79,'thompson.elise','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(28,'langworth','Jaqueline Fort','38286 Penelope Freeway','61368','Lake Laurel','+4920021003712','+8171947949422','eloy.hane@schoen.org',81,'fadel.fae','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(29,'cronin','Griffin Tunnel','131 Kaia Overpass','86501','New Enriqueview','+0964273074154','+4294569532575','satterfield.itzel@stracke.com',84,'serena.bergstrom','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(30,'oreilly','Bogisich Lane','902 Tommie Lodge Suite 441','82162','Schneidermouth','+1436234685378','+8555182674450','mayer.doris@muller.com',86,'qschimmel','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(31,'hermiston','Padberg Freeway','33793 Fay Ranch Apt. 336','72176-6979','Lake Makenzie','+1800452342666','+0525663347351','rmetz@gislason.com',88,'jared.toy','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(32,'feest','Borer Village','98072 Gianni Ranch Apt. 209','48378-7123','Donnellyville','+1589871643768','+5461476806599','cole.ewell@kuhn.com',91,'torp.lila','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(33,'volkman','Adams Track','44481 Okey Walks','14225','Willside','+9151434250331','+8096940521696','tillman.lenny@kuhlman.org',93,'vivianne.gorczany','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(34,'jaskolski','Orrin Wall','7943 Mueller Locks Suite 134','46723-7289','Lake Lolita','+8555151658250','+8755831471936','kane.cremin@upton.biz',95,'diana.schaden','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(35,'hermann','Reynolds Prairie','270 Ward Centers Apt. 304','74839','East Myrticeborough','+9237287769289','+2189668386406','heathcote.buford@mccullough.com',98,'carter.jayden','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(36,'kuhn','Marcus Prairie','921 Koch Trafficway Suite 184','64648-7245','Marquardtbury','+8289794859735','+5379811474296','zboncak.jewel@waters.com',100,'nicholas.hudson','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(37,'powlowski','Aniya Junctions','52912 Gladyce Rue','43135','East Jarvis','+1805641835737','+6282317387541','waters.erin@baumbach.biz',102,'ward32','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(38,'kertzmann','Bahringer Islands','49031 Caitlyn Bridge','75020','Anjaliview','+1677327055880','+4133608119304','cummings.wilma@harber.com',105,'astroman','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(39,'ferry','Ellie View','344 Stanton Dam','50039-9626','Myatown','+1532388270100','+9062779371846','bbogisich@erdman.com',107,'westley94','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(40,'toy','Funk Locks','873 Lexus Viaduct Suite 817','41037','West Elva','+2726541328272','+5086444925950','grayce79@schuppe.info',109,'bogisich.chaz','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(41,'hessel','Emard Divide','1095 Quigley Crossing','17560-2436','Grimesland','+0845791975163','+0701648294263','zgutmann@hagenes.com',112,'feest.gerson','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(42,'mann','Pacocha Path','6077 Jerrod Circle Apt. 756','65370','Kirstenport','+1211512556825','+8493820356964','walker55@orn.biz',114,'ankunding.daija','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(43,'sawayn','Bode Turnpike','304 Kimberly Falls','13126-8008','Gulgowskimouth','+5436283912927','+7547252951004','aemmerich@hudson.biz',116,'crunolfsdottir','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(44,'leuschke','Oran Fort','7719 Hammes Spur','71370','Lake Prince','+9611438532996','+8206451256848','modesto74@toy.com',118,'otorp','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(45,'ernser','Dorothea Corner','209 Jasmin Hill Suite 408','13009','Leslieport','+4641683160652','+4539602424390','ischuster@wiza.info',120,'hilll.dianna','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(46,'dickinson','Schmidt Groves','68306 Mason Square','36136','Katherineborough','+2669104827886','+1990876623046','roob.laura@metz.com',122,'esperanza.weber','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(47,'west','Laney Mills','1538 Wisoky Turnpike Suite 931','49154-6186','Rogahnville','+3255594441075','+1214472504497','vlittle@kshlerin.org',124,'lpredovic','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(48,'toy','Camron Garden','56077 Curt Parks','90418','Kilbackfurt','+1859338372685','+9725415785768','farrell.matilda@murray.com',126,'frieda87','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(49,'gottlieb','Osvaldo Court','46368 Edna Fork','61535','Lake Nadiaberg','+4718645740128','+9035968150796','reuben38@adams.com',128,'marquardt.donato','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(50,'reichert','Serenity Bypass','748 Wilderman Course Suite 558','27085','Vinceview','+9395887473663','+2153616739752','martin.nienow@connelly.com',130,'morissette.quentin','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(51,'wunsch','Sawayn Walk','719 Reynolds Station','95480','Maverickville','+6289982318608','+4731689206957','bruen.citlalli@towne.com',132,'lenore58','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(52,'kilback','Wiza Square','690 Zemlak Ways Suite 592','88193','Lake Luramouth','+4464388301762','+4906281972174','lisandro80@west.net',134,'vondricka','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(53,'wintheiser','Cummings Harbor','409 Tobin Square Suite 074','50920','North Dovie','+2140174457581','+2040136457512','murray34@ruecker.com',136,'stiedemann.camilla','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(54,'trantow','Russel Trafficway','53195 Monte Forges','88056','New Loisborough','+7995173191918','+5509978343791','bkihn@hermann.info',138,'cbartoletti','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(55,'langosh','Grady Summit','6844 Homenick Square Suite 888','60227-7164','Funkmouth','+6466866276066','+1508224088905','carter.esta@rice.org',140,'amari.flatley','2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table deliveries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deliveries`;

CREATE TABLE `deliveries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `delivery_contact_id` int(10) unsigned NOT NULL,
  `internal_comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deliveries_order_id_foreign` (`order_id`),
  KEY `deliveries_delivery_contact_id_foreign` (`delivery_contact_id`),
  CONSTRAINT `deliveries_delivery_contact_id_foreign` FOREIGN KEY (`delivery_contact_id`) REFERENCES `contacts` (`id`),
  CONSTRAINT `deliveries_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;

INSERT INTO `deliveries` (`id`, `order_id`, `delivery_contact_id`, `internal_comment`, `created_at`, `updated_at`)
VALUES
	(1,1,13,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(2,2,16,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(3,3,19,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(4,4,22,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(5,5,25,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(6,6,28,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(7,7,31,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(8,8,34,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(9,9,37,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(10,10,40,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(11,11,43,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(12,12,46,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(13,13,49,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(14,14,52,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(15,15,55,NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11');

/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `delivery_comments` WRITE;
/*!40000 ALTER TABLE `delivery_comments` DISABLE KEYS */;

INSERT INTO `delivery_comments` (`id`, `content`, `delivery_id`, `created_by_user_id`, `created_at`, `updated_at`)
VALUES
	(1,'Et praesentium libero voluptas cupiditate sit eaque minus quidem. Dolore odio aperiam sit accusantium consequatur. Aut sint neque aspernatur. Suscipit qui veritatis exercitationem est voluptatum odit qui.',1,23,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(2,'Eos soluta voluptatem repellendus dicta quasi sit voluptatibus. Hic non aperiam eum sit qui nemo molestiae. Voluptas non voluptas sunt voluptates veritatis minus.',2,26,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(3,'Impedit nostrum qui repudiandae voluptate asperiores aut occaecati porro. Quis dolorem dolores atque sed voluptatem. Voluptatem velit quidem sunt quo et aperiam.',3,29,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(4,'Maiores quo minima dicta cumque harum voluptate eos quod. Veritatis et ullam sunt quae voluptatibus. Accusamus sint itaque quos aspernatur. Totam beatae reprehenderit adipisci sunt delectus ipsum. Aut voluptatem repudiandae sit in magnam.',4,32,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(5,'Cupiditate ut eius commodi sint repudiandae voluptates. Consequatur libero et architecto. Et quis eum ipsum omnis aspernatur molestiae.',5,35,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(6,'Non eos sunt enim. Nam necessitatibus repellendus voluptatem suscipit.',6,38,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(7,'Provident perspiciatis qui doloribus et eos impedit quis. Tenetur rerum et unde fugiat exercitationem. Sit maxime velit corrupti. Architecto sed est voluptas ipsa officiis.',7,41,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(8,'Quaerat asperiores et rerum commodi rerum voluptas. Voluptate ad velit modi. Tenetur nesciunt maxime minus facilis. Et sunt in laboriosam magni architecto.',8,44,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(9,'Qui in numquam dolorum saepe harum. Sint impedit veniam incidunt autem voluptas odio. Cumque omnis provident totam.',9,47,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(10,'Dignissimos et temporibus et quaerat dolorem. Hic ab occaecati consequatur commodi cumque sed dicta enim. Sit quis iusto voluptates maxime. Placeat autem rerum voluptas voluptas quo.',10,50,'2017-06-01 18:57:11','2017-06-01 18:57:11');

/*!40000 ALTER TABLE `delivery_comments` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;

INSERT INTO `documents` (`id`, `file_name`, `file_path`, `mime_type`, `quantity`, `rolled_folded_flat`, `length`, `width`, `nb_orig`, `free`, `format_id`, `delivery_id`, `main_article_id`, `created_at`, `updated_at`)
VALUES
	(1,'9787241788416.wmlc','/path/to/file/','application/vnd.fdsn.mseed',96,'rolled',59,16,5,1,1,11,1,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(2,'9796098355313.ahead','/path/to/file/','application/x-bzip',51,'flat',35,99,4,1,2,12,2,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(3,'9797803430783.sgm','/path/to/file/','video/x-ms-wmx',60,'rolled',35,72,5,1,3,13,3,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(4,'9785840222294.tao','/path/to/file/','application/x-x509-ca-cert',51,'flat',96,9,6,1,4,14,4,'2017-06-01 18:57:11','2017-06-01 18:57:11'),
	(5,'9782240025005.msf','/path/to/file/','application/vnd.oma.dd2+xml',17,'folded',89,7,4,0,5,15,5,'2017-06-01 18:57:11','2017-06-01 18:57:11');

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
  `surface` decimal(8,2) DEFAULT NULL,
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
	(1,'huels',18,21,6725.00,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(2,'schmitt',44,7,2360.00,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(3,'watsica',62,80,16429.00,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(4,'lakin',59,88,57221.00,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(5,'klocko',5,58,15233.00,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

/*!40000 ALTER TABLE `formats` ENABLE KEYS */;
UNLOCK TABLES;


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
	(201,'2014_10_12_000000_create_users_table',1),
	(202,'2014_10_12_100000_create_password_resets_table',1),
	(203,'2017_05_09_163758_create_businesses_table',1),
	(204,'2017_05_09_172315_create_companies_table',1),
	(205,'2017_05_09_173405_create_contacts_table',1),
	(206,'2017_05_09_185357_create_orders_table',1),
	(207,'2017_05_10_084559_create_formats_table',1),
	(208,'2017_05_10_085200_create_categories_table',1),
	(209,'2017_05_10_085535_create_articles_table',1),
	(210,'2017_05_10_090336_create_documents_table',1),
	(211,'2017_05_10_141954_create_business_comments_table',1),
	(212,'2017_05_10_142209_create_delivery_comments_table',1),
	(213,'2017_05_10_142429_create_deliveries_table',1),
	(214,'2017_05_10_145628_add_foreign_keys_articles_table',1),
	(215,'2017_05_10_163217_add_foreign_keys_business_comments_table',1),
	(216,'2017_05_10_164835_add_foreign_keys_businesses_table',1),
	(217,'2017_05_10_165803_add_foreign_keys_companies_table',1),
	(218,'2017_05_10_165804_add_foreign_keys_contacts_table',1),
	(219,'2017_05_10_172845_add_foreign_keys_deliveries_table',1),
	(220,'2017_05_10_173205_add_foreign_keys_delivery_comments_table',1),
	(221,'2017_05_10_173543_add_foreign_keys_documents_table',1),
	(222,'2017_05_10_181450_add_foreign_keys_orders_table',1),
	(223,'2017_05_18_130838_add_foreign_keys_users_table',1),
	(224,'2017_06_01_000000_create_article_document_table',1),
	(225,'2017_06_01_100000_add_foreign_keys_article_document_table',1);

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

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO `orders` (`id`, `reference`, `status`, `business_id`, `billing_contact_id`, `created_by_user_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'39342234','ok',11,12,22,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(2,'99329796','nok',12,15,25,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(3,'81832617','nok',13,18,28,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(4,'30612567','ok',14,21,31,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(5,'40106141','nok',15,24,34,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(6,'74721665','ok',16,27,37,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(7,'52325528','ok',17,30,40,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(8,'53517789','ok',18,33,43,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(9,'44643198','nok',19,36,46,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(10,'48429','nok',20,39,49,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(11,'52914351','ok',21,42,52,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(12,'82609415','nok',22,45,54,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(13,'79042840','nok',23,48,56,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(14,'31101719','ok',24,51,58,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(15,'97225024','ok',25,54,60,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

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
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_validated` tinyint(4) NOT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_contact_id_foreign` (`contact_id`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `users_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `email_validated`, `contact_id`, `company_id`, `remember_token`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'tconnelly','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','kuphal.cleora@example.net',1,NULL,3,'XFrDZ20Bck',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(2,'mosciski.elwyn','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','adams.pansy@example.org',1,NULL,4,'zRzNJDkMcd',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(3,'frami.donny','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','gleichner.dagmar@example.com',1,NULL,7,'9vY48l2iUI',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(4,'xullrich','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','mante.benny@example.org',1,NULL,8,'6yfFR6rCqJ',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(5,'runolfsson.sharon','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','theodora53@example.com',1,NULL,11,'pXXNPTeBXz',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(6,'german84','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','hane.danika@example.com',1,NULL,12,'cMPFxn4JSk',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(7,'eileen.ortiz','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','guido.barton@example.net',1,NULL,15,'fkCfLx3bGZ',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(8,'macejkovic.don','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','carrie.grimes@example.org',1,NULL,16,'NhhT4s1XkE',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(9,'alexie90','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','angeline.hackett@example.com',1,NULL,19,'9x3CTKa57L',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(10,'charity.rosenbaum','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','houston.hoeger@example.net',1,NULL,20,'RQP9e0KwuH',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(11,'nmills','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','leon74@example.com',1,NULL,23,'ez2wz3MBO3',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(12,'kulas.stacey','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','hulda56@example.org',1,NULL,24,'icF78KtBoI',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(13,'denesik.mollie','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','krystal39@example.net',1,NULL,27,'FPMaRRHYBq',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(14,'glockman','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','kgrant@example.com',1,NULL,28,'ccmv7FPOz3',NULL,'2017-06-01 18:57:10','2017-06-01 18:57:10',NULL),
	(15,'roselyn.jakubowski','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','ocole@example.org',1,NULL,31,'k3QEbwT1Pt',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(16,'collier.omer','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','ometz@example.org',1,NULL,32,'0PLm3CPCkZ',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(17,'quitzon.margaret','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','mitchel90@example.net',1,NULL,35,'PTlR3psn5y',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(18,'verda.dicki','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','omari.stokes@example.com',1,NULL,36,'gwBV62WSCL',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(19,'powlowski.hardy','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','delpha.stehr@example.org',1,NULL,39,'Yjk0BOlXwF',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(20,'hickle.mona','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','fconroy@example.net',1,NULL,40,'ant619pOf8',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(21,'mya.franecki','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','fleta38@example.org',1,NULL,43,'OLUdGqHaLO',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(22,'felix.dickens','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','carmelo.cummings@example.org',1,NULL,45,'cwX9d24SeD',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(23,'xjaskolski','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','lhyatt@example.org',1,NULL,47,'qSShV78Ueg',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(24,'vstamm','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','foster.maggio@example.com',1,NULL,50,'eGeCbFcdW3',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(25,'gusikowski.gussie','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','ykunde@example.net',1,NULL,52,'i64jylGZGP',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(26,'drew.blanda','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','rod.langworth@example.net',1,NULL,54,'NZ8CZpR9VW',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(27,'hauck.haley','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','qnikolaus@example.net',1,NULL,57,'G9gIZWpyYH',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(28,'kzieme','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','akerluke@example.org',1,NULL,59,'s8wmvEBRIX',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(29,'abigail.lind','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','runolfsdottir.noemy@example.org',1,NULL,61,'LRjPs9NZNo',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(30,'madisyn89','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','mfeil@example.net',1,NULL,64,'3MOVSttBhA',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(31,'keenan22','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','deckow.reba@example.com',1,NULL,66,'2h4Lce7kaK',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(32,'yheidenreich','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','rodriguez.esmeralda@example.org',1,NULL,68,'3LqQ8ON5AH',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(33,'weimann.tevin','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','bward@example.com',1,NULL,71,'kM82B6SEWg',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(34,'harmony.ward','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','fheathcote@example.com',1,NULL,73,'GuuleeRY8H',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(35,'ciara60','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','crona.lucie@example.com',1,NULL,75,'cooIjzqhhV',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(36,'virginie.langosh','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','joey.kunde@example.net',1,NULL,78,'N4pFQJdsYT',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(37,'uherman','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','micaela.dickens@example.com',1,NULL,80,'NCsYP9VIa3',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(38,'daniela.rice','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','abbott.vance@example.org',1,NULL,82,'FsKnqKCaF9',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(39,'roberta.schimmel','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','ocrooks@example.org',1,NULL,85,'H4H853cyoW',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(40,'murray.lang','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','parisian.trent@example.com',1,NULL,87,'PcTSzTlHbV',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(41,'feil.werner','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','hilda.howe@example.org',1,NULL,89,'UzQUDpw2HF',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(42,'breitenberg.lorenzo','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','dorcas94@example.com',1,NULL,92,'52usTKl4yO',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(43,'upacocha','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','gerlach.magnus@example.net',1,NULL,94,'12arVM1JAp',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(44,'alvah03','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','williamson.geraldine@example.org',1,NULL,96,'ZDgugRi8Uh',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(45,'othompson','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','xwisoky@example.com',1,NULL,99,'KsNF2kg9oh',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(46,'stehr.kirstin','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','flatley.erna@example.net',1,NULL,101,'k5X6PnfCYw',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(47,'xavier.hansen','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','taya91@example.org',1,NULL,103,'CVxbdoz9il',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(48,'carter.mandy','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','bergnaum.gennaro@example.com',1,NULL,106,'gtYF9bSiVq',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(49,'jweimann','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','gerlach.dean@example.net',1,NULL,108,'pBVdDUgUTp',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(50,'boyd.casper','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','ubins@example.org',1,NULL,110,'c4uX67KkOv',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(51,'oberbrunner.celestine','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','eulah65@example.com',1,NULL,113,'RE1LXLJgit',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(52,'wheathcote','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','rocky.treutel@example.org',1,NULL,115,'m7HxrdMZza',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(53,'wiley93','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','kuhlman.giles@example.com',1,NULL,119,'RdEKjalaNF',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(54,'cecile.jakubowski','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','harris.ford@example.net',1,NULL,121,'ZXdXr0bZiz',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(55,'bfeil','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','admin','derrick.bode@example.net',1,NULL,125,'oIUR4Ctr4q',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(56,'hhudson','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','trenton.crooks@example.com',1,NULL,127,'qzCopqdPHy',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(57,'little.brenden','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','gia08@example.com',1,NULL,131,'3JaJrFX8F3',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(58,'vella39','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','esta.kuphal@example.com',1,NULL,133,'Y56h51g6OS',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(59,'nicolas.daphnee','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','doyle.linnie@example.com',1,NULL,137,'8uoNr9QrSV',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL),
	(60,'alison.mills','$2y$10$Hy73CpPNLyYpB9IBFtqNdOBIuPcP2J1ASYAC/EwoXubF194g6BFSy','user','epacocha@example.net',1,NULL,139,'snsuJGHGdo',NULL,'2017-06-01 18:57:11','2017-06-01 18:57:11',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
