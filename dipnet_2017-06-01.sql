# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17-0ubuntu0.16.04.1)
# Database: dipnet
# Generation Time: 2017-06-01 15:02:48 +0000
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

INSERT INTO `articles` (`id`, `reference`, `description_web`, `description_dip`, `required_printing`, `public`, `consumable`, `category_id`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'77353347','Occaecati non culpa natus.','Occaecati non culpa natus.',1,0,1,1,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(2,'14060910','Natus dolor voluptatibus at.','Natus dolor voluptatibus at.',1,0,1,2,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'57788083','Facere quaerat qui saepe impedit.','Facere quaerat qui saepe impedit.',1,0,0,3,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'46562121','Voluptates aperiam commodi ut totam.','Voluptates aperiam commodi ut totam.',1,0,1,4,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'57189852','Amet delectus ullam omnis est cum aut.','Amet delectus ullam omnis est cum aut.',0,1,0,5,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

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
	(1,'Omnis et quos asperiores voluptas porro. Quis quidem quia quibusdam dicta. Nesciunt hic quo quia dolore fugiat assumenda aut. Enim veritatis rem blanditiis officia sunt. Ut eum corporis et in corrupti.',1,2,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(2,'Enim quae cupiditate quas ut est explicabo. Eum nobis est aliquid recusandae. Sunt ratione inventore qui ut fugiat harum inventore. Aut sequi quia est quasi omnis.',2,4,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(3,'Nostrum aut culpa fugit quidem. Voluptas in molestiae exercitationem quae possimus rerum iste aut. Aut cupiditate error ducimus et sed voluptas eos. Qui voluptatem veritatis consequatur commodi quae labore quas. Et tempora aspernatur cumque architecto aliquam illo amet nisi.',3,6,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(4,'Expedita alias odit modi fuga aut minima. Nam quas eos sit accusamus reiciendis dolore. Aliquam enim sed necessitatibus nostrum sit enim repudiandae.',4,8,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(5,'A quasi reiciendis porro maxime suscipit quis. Aspernatur et maxime aut voluptatem ut quod sint. Accusantium cum beatae nihil quam rerum explicabo dolores qui.',5,10,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(6,'Quaerat non fugiat molestias. In est inventore iure non dolore qui dignissimos ut. Laborum vel itaque laboriosam maxime magni fugit.',6,12,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(7,'Laboriosam asperiores officia et vel quam quisquam consequatur. Vel iure eaque et eos. Numquam ut a non officia provident optio. Et aliquam ut laborum qui repudiandae voluptatem.',7,14,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(8,'Expedita tempora ipsam sed ut aut odit. Et et voluptatem expedita quae maxime ratione.',8,16,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(9,'Itaque et eos qui voluptas dolore. Nisi quia itaque facilis quo reprehenderit similique. Eos rerum voluptatem exercitationem ut quaerat neque. Qui incidunt sint et repellat deserunt.',9,18,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(10,'Debitis quasi pariatur ut ipsa vel facere itaque. Deleniti ex magnam incidunt velit omnis. Odit aliquid eius maxime recusandae hic. Distinctio aut debitis ex. Quae fuga dolorem suscipit consequatur voluptatem.',10,20,'2017-05-26 08:08:01','2017-05-26 08:08:01');

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
	(1,'Tremblay Ltd','39953640','Digitized optimizing capability',1,1,'1','2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(2,'Klocko, Shanahan and Maggio','63095189','Exclusive fault-tolerant hardware',5,2,'3','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'Bayer-Parker','1435327','Vision-oriented secondary migration',9,3,'5','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'Runolfsdottir, Hoppe and Lindgren','19425813','Multi-lateral background analyzer',13,4,'7','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'Turner LLC','40515320','Distributed transitional definition',17,5,'9','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(6,'Rosenbaum, Marquardt and Kassulke','82957721','Versatile national collaboration',21,6,'11','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(7,'Rowe Inc','38896073','User-friendly secondary model',25,7,'13','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(8,'Will PLC','80913508','Universal incremental framework',29,8,'15','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(9,'Satterfield LLC','95691718','Re-contextualized real-time function',33,9,'17','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(10,'Kemmer Group','65368321','Operative local database',37,10,'19','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(11,'Schimmel PLC','56265840','Horizontal incremental solution',41,11,'21','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(12,'Kovacek, Ondricka and Paucek','55604995','Object-based attitude-oriented hierarchy',48,14,'24','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(13,'D\'Amore, Sporer and Barton','83999207','Devolved discrete methodology',55,17,'27','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(14,'Bechtelar, Huels and Von','6455165','Adaptive asynchronous standardization',62,20,'30','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(15,'Hoppe, Price and Emard','98810716','Stand-alone client-server implementation',69,23,'33','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(16,'Cormier, Wintheiser and O\'Kon','87905943','Robust high-level hierarchy',76,26,'36','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(17,'Gibson Inc','8492721','User-centric bi-directional implementation',83,29,'39','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(18,'Nolan Inc','58232498','Optional tangible structure',90,32,'42','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(19,'Nolan, Hamill and Torphy','2901813','Fundamental uniform pricingstructure',97,35,'45','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(20,'Haag, Conroy and Keeling','36320499','Quality-focused intangible hardware',104,38,'48','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(21,'Wilkinson, Ziemann and Keeling','25172596','Inverse content-based attitude',111,41,'51','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(22,'Grant-McCullough','12579434','Monitored fault-tolerant capability',117,44,'53','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(23,'Von-Skiles','5785887','Secured client-driven monitoring',123,47,'55','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(24,'Cruickshank, Maggio and Grimes','55672910','Mandatory modular implementation',129,50,'57','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(25,'Lubowitz-Kozey','87808608','Future-proofed radical definition',135,53,'59','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

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
	(1,'bashirian','2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(2,'wisoky','2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(3,'okeefe','2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(4,'schumm','2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(5,'mcdermott','2017-05-26 08:08:01','2017-05-26 08:08:01');

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

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;

INSERT INTO `companies` (`id`, `name`, `status`, `description`, `address_line1`, `address_line2`, `zip`, `city`, `phone_number`, `fax`, `email`, `created_by_username`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'Wilderman-Hansen','ok','Automated 4thgeneration support','Witting Hills','52049 Kihn Ville','39298-1772','Krajcikmouth','+9612526304900','+2805977155597','rebecca.medhurst@gutkowski.com','omer.murray','2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(2,'Schulist LLC','nok','Progressive methodical framework','Elbert Parks','13102 Bergnaum Point Suite 534','10769-2960','Alexaburgh','+5060837203484','+3850290268691','franecki.arnulfo@herman.com','umitchell','2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(3,'Hettinger, Rohan and Block','ok','Robust hybrid help-desk','Murray Coves','800 Kane Lane Apt. 149','28885-6294','Fredyhaven','+5192810537670','+6866773134313','emmy55@wisozk.com','joaquin.raynor','2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(4,'Dietrich Group','ok','Monitored demand-driven encoding','Jedediah Heights','287 Oral Shore Apt. 498','97941','Orionfort','+8497591452764','+8223515059439','liana54@ebert.com','purdy.gregory','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'Cummings and Sons','nok','De-engineered user-facing utilisation','Schaefer Centers','321 Reese Ville','71209-6681','South Jayde','+2862634987925','+4556055999783','maryse88@kshlerin.com','will.bernhard','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(6,'Corkery Ltd','ok','Ergonomic human-resource GraphicInterface','Freeman Throughway','94638 Klein Mall','18641','Haleytown','+9702462600389','+8589733986836','lesch.myrtle@dooley.com','leone07','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(7,'Wunsch, Parker and Wisozk','ok','Quality-focused didactic systemengine','Swift Light','90323 Scotty Common','69094-6237','West Dallasburgh','+7749637645783','+8574445513816','marcel39@lind.org','labadie.sylvan','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(8,'Bogisich Group','nok','Multi-channelled 5thgeneration pricingstructure','Stanton Falls','6707 Tillman Way Apt. 813','51567-8819','Feeneyland','+6568505763848','+2893343449004','ktromp@walker.net','renner.savanna','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(9,'Collins-Homenick','nok','Adaptive system-worthy matrices','Bridget Trafficway','7230 Hoppe Causeway','94218','South Herminiaville','+8478281692442','+2514839630829','elvis02@padberg.info','johan08','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(10,'Hessel, Dietrich and Abshire','nok','Fundamental exuding encoding','Emard Ports','184 Russel Estate','06146-2645','Lake Sigmund','+5628859882285','+2676065863723','lemke.wilton@jones.org','schaefer.riley','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(11,'Borer, Larkin and Batz','ok','Proactive dedicated parallelism','Terry Views','972 Linwood Hollow','45634-8357','Sawaynmouth','+4370722798558','+5463054503677','lswift@bradtke.info','jammie.lebsack','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(12,'Heaney, Mayer and Herman','nok','Versatile bi-directional alliance','Quigley Spurs','987 Genesis Neck','17892','Greenholtchester','+2575128074306','+5391659749647','cummings.shawn@roberts.com','jhartmann','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(13,'Treutel, Leffler and Gaylord','nok','Expanded contextually-based parallelism','Amiya Estates','32939 Cremin Streets Suite 530','04379','North Jeanfurt','+7136741126179','+0817017312342','trudie.ullrich@cremin.info','kvandervort','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(14,'Kovacek-Berge','nok','Mandatory local archive','Yost View','782 Heathcote Haven Apt. 079','72934-0585','Emeraldfurt','+7873678407284','+2661086788760','ischimmel@feest.com','jennyfer10','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(15,'Rodriguez Inc','ok','Digitized attitude-oriented instructionset','Louvenia Throughway','234 Bins Extension','67336','Tristinchester','+4581956597272','+9574459720000','pabernathy@leuschke.info','akreiger','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(16,'Rippin, Lemke and Dietrich','ok','Realigned heuristic parallelism','Ena Spurs','11760 Isaias Way Suite 238','66097','Johnsonburgh','+2447120985745','+1863056511272','gaylord.clay@carter.com','pagac.heidi','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(17,'Robel Inc','nok','Streamlined secondary localareanetwork','Dare Pines','64781 Rohan Track','34086-1625','South Ursulashire','+8351535961083','+3817179762441','llang@waelchi.com','marlee91','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(18,'Metz-Kertzmann','ok','Team-oriented logistical utilisation','McKenzie Parks','36953 Cordelia Corner','29640-3962','Port Kiana','+0952479554601','+3095965743465','melyssa81@nader.com','rath.elvie','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(19,'Brakus, Sporer and Kuhn','nok','Cloned 24hour challenge','Ratke Falls','86815 Daryl Tunnel','33508','Meganefort','+4471952496315','+1475143724098','wyatt.kirlin@gerlach.com','ritchie.cecelia','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(20,'Feeney, Wilkinson and Pollich','ok','Cross-platform transitional forecast','Emilie Corner','17795 Schroeder Flat','37744','Breitenbergstad','+7310711457458','+6897417019300','oschiller@kertzmann.org','padberg.liza','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(21,'Hayes, Huel and Bartoletti','nok','Digitized dynamic productivity','Nora River','441 Rubie Road Apt. 599','11574-8012','Lake Gilbertstad','+8827426211502','+8137177246473','mathew68@littel.com','aledner','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(22,'Harber-Berge','nok','Innovative fault-tolerant product','Flatley Drive','3895 Ebert Divide','11662','Lake Mathildeburgh','+2894873704547','+9700530008581','kreiger.assunta@denesik.org','terrance.haag','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(23,'Reilly-Raynor','nok','Public-key bottom-line core','Kertzmann Village','7909 Conrad Springs','19708','Erikastad','+7996608770426','+3815471994827','prohaska.buddy@hamill.com','nadia68','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(24,'Willms, Wunsch and Zulauf','ok','Business-focused background algorithm','Ortiz Glen','4744 Jamarcus Circle Suite 476','97974','Gleasonton','+9391652696502','+8902053449158','emmie02@heidenreich.info','vidal39','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(25,'Fritsch-Frami','nok','Visionary even-keeled middleware','Eli Loop','60127 Burley Locks','93471-2816','Omarimouth','+1792130569187','+5811217750260','efrain02@fritsch.biz','wolff.oliver','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(26,'Collins-Hoeger','ok','Expanded web-enabled portal','Garfield Mountains','99769 Deja Locks','41714-6573','Eileenview','+5543742518673','+0443322725712','mohamed00@feeney.com','ambrose.dicki','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(27,'Gleichner Ltd','nok','Polarised multi-state localareanetwork','Millie Village','6183 Brook Springs','14592-0651','Kelliefort','+5344133373598','+7446188077857','ustracke@reynolds.biz','alejandrin.wolff','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(28,'Oberbrunner-Bayer','ok','Organic zeroadministration opensystem','Nolan Court','47209 Antonietta Loop','74497-1048','West Rocio','+7593334377410','+6828652814427','deckow.lucinda@olson.com','kreiger.baylee','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(29,'Davis and Sons','ok','Extended exuding adapter','Hartmann Roads','5108 Farrell Hill','67288-0054','West Hank','+8287759792444','+7933182569706','arnold59@windler.com','alayna14','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(30,'Lueilwitz, Schumm and Koelpin','nok','Balanced assymetric archive','Watsica Ways','4572 Coy Lane','18831','Lake Devonview','+4698883448451','+2808976558236','eladio.bogisich@cummings.org','susana11','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(31,'Rogahn-Rodriguez','nok','Up-sized analyzing openarchitecture','Marco Squares','2167 Heaney Heights Suite 189','48087-2729','Hipolitoton','+3610672153172','+9696022826403','vbraun@altenwerth.info','nia02','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(32,'Hintz-Dietrich','nok','Organized systematic migration','Carroll Lodge','44910 Ophelia Drives Apt. 317','10504','West Janessa','+0420770756324','+7702053766416','jimmie.christiansen@considine.com','stoltenberg.abraham','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(33,'Bartoletti-Schmidt','nok','Progressive grid-enabled migration','Douglas Glens','3554 Zulauf Meadow','34989-3028','Port Kali','+4526855580081','+6304968380820','volkman.joan@blick.com','oreilly.ebony','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(34,'Hand-Beatty','ok','Enhanced context-sensitive frame','Edwin Green','1820 Jon Grove','63020','Rodrickstad','+0622938649416','+4480819441863','welch.heaven@bechtelar.net','autumn52','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(35,'Beatty Group','nok','Future-proofed high-level neural-net','Schinner Trafficway','9961 Lind Road Suite 720','64492-1632','East Alysha','+2976570914675','+5643241055022','travon30@lesch.com','uroob','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(36,'VonRueden-Fay','ok','Function-based coherent architecture','Zulauf Via','29714 Sigrid Avenue','94448-9321','West Colt','+9575807654295','+5328804226019','ocie89@greenholt.com','aufderhar.jaden','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(37,'Weissnat, Orn and Zemlak','ok','Optional secondary moratorium','Kuphal Throughway','9081 Reynolds Locks Suite 867','49979-6963','Bahringerhaven','+9950924690589','+6451407727285','kunze.carley@bahringer.com','rogelio50','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(38,'Hane, Rosenbaum and Reinger','nok','Object-based scalable infrastructure','Wehner Drives','90688 Laurence Pike Suite 827','60990-8410','Port Lelahport','+5328259524838','+5079826505837','ngrady@thiel.com','yhirthe','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(39,'Olson, Armstrong and Swaniawski','ok','Vision-oriented national workforce','Ludie Turnpike','1435 Uriel Corner','62239-7138','Kirlinmouth','+9731532996981','+3424306664464','maida44@fay.org','bruen.angela','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(40,'Corwin and Sons','nok','Self-enabling holistic complexity','Ola Course','41324 Bruen Pine','92276-4451','Lake Bonnie','+9403764848146','+2099321098394','kay.marks@reynolds.com','lenna73','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(41,'Brown Inc','nok','Inverse fault-tolerant strategy','Jeremy Plain','883 Gonzalo Shoal','29457','East Hailey','+1328352242699','+9872238693877','marisol.dickinson@auer.com','dhamill','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(42,'Mosciski, Lowe and Breitenberg','nok','Open-source contextually-based approach','Marvin Mills','66572 Nikolaus Heights Apt. 043','77608','Lake Greta','+4491759922073','+3956557091946','tavares.orn@bartoletti.com','forest.corkery','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(43,'Boyer-Swaniawski','ok','Universal global function','Ruthie Brook','785 Roberts Court','79823-9097','Nienowmouth','+5631733750897','+9972874934639','kylee.homenick@mcdermott.com','wswift','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(44,'Rutherford, Muller and Jenkins','ok','Phased foreground synergy','Zulauf Street','89927 Valentine Isle Apt. 143','56987','South Augustview','+3682451139602','+6891574057944','armstrong.imani@schowalter.biz','kole.medhurst','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(45,'Berge, Corkery and Kemmer','nok','Configurable optimizing monitoring','Melba Fields','958 Elwyn Lakes','92026-4199','Lake Tania','+5406150299218','+2009760141381','qkutch@raynor.com','emerson28','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(46,'Schoen, Reichel and Mills','ok','Reverse-engineered foreground service-desk','Alfreda Shoals','502 Mable Rapid Apt. 271','09989-6194','Marianetown','+9911509493339','+8268380744483','annalise37@schaefer.info','linwood.mcdermott','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(47,'Harvey-Hodkiewicz','nok','Organized 3rdgeneration firmware','Iva Burgs','591 Reagan Neck','20854-9156','South Gilberto','+3764891779374','+6116910814749','tromp.gunnar@rippin.org','bernard.batz','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(48,'Grady, Skiles and Schneider','ok','Distributed even-keeled service-desk','Heidenreich Landing','731 Melvina Junction Apt. 331','83465-2681','North Keith','+5616491526139','+7756229773331','brandt.mohr@bashirian.biz','marianne.trantow','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(49,'Kovacek Group','nok','Advanced analyzing ability','Brenda Brooks','73678 Hettie Junctions','08676','Torpfurt','+1148690987458','+9252447006987','tyrique.bartell@lynch.com','ava.kling','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(50,'Hessel, Upton and Kuvalis','ok','Synergistic homogeneous infrastructure','Alvera Forks','32885 Langworth Mission Apt. 460','67564-7354','West Liliane','+9704512883904','+0426378919519','gutkowski.muriel@kuhic.com','marian.yundt','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(51,'Batz-Maggio','nok','Synchronised 4thgeneration forecast','Rogahn Manor','2719 Emie Mill Apt. 355','68888-6996','Gerholdborough','+1609844440488','+5253058969260','taryn26@kertzmann.com','jerrod64','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(52,'Botsford and Sons','nok','Operative empowering benchmark','Quinten Drive','1003 Pierce Hollow Apt. 424','46899','Minachester','+8895504462460','+3146884350857','jodie.williamson@lesch.com','deckow.jordyn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(53,'Bergnaum-Dicki','nok','Enhanced tertiary software','Schamberger Avenue','116 Kamryn Prairie','70061','Schuppeport','+3509814311611','+9173342035200','mariana.sporer@legros.com','kaleb.crona','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(54,'Schuster PLC','nok','Proactive attitude-oriented database','Rogelio Pike','329 Earline Drive Apt. 802','02301-8506','Elisemouth','+3121311874027','+4734731410187','jamel75@medhurst.com','uzieme','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(55,'Witting-Cassin','ok','Cross-group didactic algorithm','Jacey Island','184 Reilly Streets Apt. 293','67185-4523','Mertzbury','+4805254232246','+2453830436372','oswift@schultz.net','jhaag','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(56,'Erdman-Langworth','ok','Persistent homogeneous alliance','Donnell Points','49898 Aglae Inlet','86226','North Lonnie','+9537890005453','+4424228848633','stephanie.hane@hackett.com','pvon','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(57,'Williamson-Haley','nok','Fully-configurable exuding challenge','Pacocha Overpass','4406 Eichmann Orchard','54619-7564','Ernieside','+7387790330001','+5895968106104','mhansen@walter.com','rudy.collins','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(58,'Kessler-Johns','nok','Optional demand-driven definition','Alexis Dale','27400 Lou Ports Suite 568','01313-0278','New Kittymouth','+1609415757856','+3740178524221','nelle91@ebert.com','anais90','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(59,'McGlynn Ltd','ok','Reactive coherent challenge','Maximillian Underpass','70320 Beer Rapid Suite 799','25420','Wehnerstad','+2464210090442','+8895272784683','xwindler@mraz.info','karson30','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(60,'Corwin-Gaylord','nok','Extended 6thgeneration localareanetwork','Stella Inlet','2228 Rubie Roads','48878','Rennerton','+0655773512244','+8514169831500','schaefer.bruce@walker.net','xkonopelski','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(61,'Hermiston-Cronin','nok','Implemented value-added implementation','Porter Circles','1129 Shawn Canyon Suite 166','35336-5581','Allieton','+7233933809422','+0206428117635','shanon.ritchie@graham.net','milford98','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(62,'Labadie PLC','nok','Fundamental full-range extranet','Kristofer Centers','99097 Dietrich Rest','36113','Lindgrenbury','+4942689857104','+0409032698783','iboyle@adams.com','hudson.denesik','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(63,'Fisher LLC','ok','Enterprise-wide explicit protocol','Dibbert Track','141 Larkin Cliffs','78673','O\'Connellton','+9303661848834','+5090952293666','vschoen@mclaughlin.biz','ethelyn44','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(64,'Trantow, Raynor and Lueilwitz','ok','Switchable object-oriented firmware','Durward Key','962 Spinka Viaduct Suite 648','36565-1945','Myahview','+6733700417541','+9896463886792','annie.jaskolski@satterfield.com','ibednar','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(65,'Hegmann, Ferry and Tillman','ok','Synergistic asynchronous success','Verda Land','272 Bobby Coves Suite 385','04066','West Brice','+0721176131524','+6050214260600','garry67@okon.com','littel.jazmin','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(66,'Bauch-Balistreri','ok','Customer-focused dedicated application','Skiles Court','85887 Sadye Circles','18258-6760','North Myrtle','+3085709635996','+1539348210181','zokuneva@kilback.com','chase22','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(67,'Schaden-Kuvalis','ok','Realigned even-keeled knowledgebase','Thiel Mount','71254 Sanford Centers Suite 529','95709-9713','Konopelskichester','+2937544760358','+9924464507067','lconsidine@ernser.biz','destiney.funk','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(68,'Buckridge, Langworth and Glover','nok','Team-oriented neutral superstructure','Jasper Isle','68144 Schroeder Canyon Suite 401','21177-8716','Glennaburgh','+0446674962507','+6302634139787','josie27@raynor.com','abbott.margarett','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(69,'Adams and Sons','ok','Versatile 6thgeneration methodology','Grayce Keys','280 Bernhard Falls','11022-0089','South Taurean','+2216595877814','+1109980560867','doug.robel@sipes.info','daija44','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(70,'Willms-Ziemann','ok','Cloned system-worthy data-warehouse','Santino Parkways','33854 Smith Ridges','50112','Port Juanita','+4639133223417','+0881776092793','pbeahan@reynolds.com','gerhold.thaddeus','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(71,'Von, Mitchell and Tromp','ok','Optimized discrete architecture','Ivy Rapid','126 Kuhic Tunnel','85730','Wilhelmineport','+2160573785065','+9230732832877','gulgowski.karl@hessel.com','qcarter','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(72,'Leuschke, Macejkovic and Schuster','nok','Programmable multi-state infrastructure','Wilfredo Mount','599 Maritza Gardens Apt. 268','66162','Lake Lura','+5791597886889','+2178338968906','anderson27@bayer.info','tgleason','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(73,'Pouros-Rau','ok','Synergistic transitional workforce','Daniel Heights','530 Oberbrunner Turnpike','70257-2575','Madalynshire','+7168252566681','+4769839829758','pacocha.lurline@murray.com','vhahn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(74,'Emmerich, Collins and Feest','ok','Proactive multimedia workforce','Mann Groves','24477 Maggio Inlet','28091','Rudolphhaven','+8074451284939','+0675965574854','lindsey01@zemlak.com','delores.johnston','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(75,'Blanda, Bernier and Price','ok','User-centric national moderator','Maggio Roads','25856 Hartmann Island Apt. 831','71900','Port Angusmouth','+3257112314644','+3769391119418','coralie07@hyatt.info','bernadine34','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(76,'Schmitt, Hermiston and Heaney','nok','Assimilated heuristic collaboration','Bins Wall','330 Langworth Lodge Apt. 087','02772-1148','Robertafort','+2298869445969','+1619416781718','susie.bosco@cruickshank.org','huels.mallory','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(77,'Treutel, Lebsack and Macejkovic','ok','Right-sized disintermediate application','Amiya Tunnel','77189 Palma Trafficway Apt. 982','41209','Floburgh','+4863790477853','+6855638174110','sdicki@auer.com','karlee.reilly','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(78,'Boyer Inc','nok','Function-based zerotolerance toolset','Williamson Forest','708 Lockman Crossing','03439','East Hazel','+8373779252705','+3512189826683','delphia77@becker.com','miguel.keebler','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(79,'Sawayn-Batz','nok','Multi-tiered assymetric toolset','Collier Path','78714 Dylan Shoal','24593','Johnstonland','+9997521199688','+1532809695085','alangworth@simonis.com','tremayne.huel','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(80,'Haley, Botsford and Emmerich','ok','Multi-lateral secondary paradigm','Stoltenberg Run','627 Price Lakes Apt. 191','41348','East Amaya','+5969076071560','+3873319059965','dcrist@lockman.net','icie34','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(81,'Thiel-Torp','ok','Decentralized 24hour installation','O\'Reilly Manors','4644 Johanna Shore','38326','Mosciskiberg','+3563627574436','+5232030840586','obeier@huel.net','ohowe','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(82,'Towne, Kutch and Goodwin','ok','Enterprise-wide fault-tolerant productivity','Brett Drive','159 Letha Mews','37522','East Conor','+2345785667824','+4273653924173','ora10@marks.com','kuhic.delta','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(83,'Bahringer-Abshire','nok','Centralized needs-based matrices','Wolff Causeway','35601 Wisozk Highway','82798-2961','Lake Adela','+0145549123548','+5369317421083','josh37@schinner.com','eliza.mcglynn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(84,'Johns, Runolfsson and Lang','nok','User-friendly stable archive','Ward Springs','3927 Kamren Mission Apt. 001','29467','Lake Tyraberg','+0932140212517','+8172552838426','hziemann@reichert.com','xswaniawski','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(85,'Hessel-Lang','nok','Re-engineered assymetric moderator','Floyd Falls','7163 Woodrow Cliff','76756','South Maybell','+6823572328388','+6265051792304','pcremin@kassulke.biz','keshawn.white','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(86,'Wolff PLC','nok','Fully-configurable secondary interface','Boris Mountains','510 Ratke Ford Suite 380','31026','Leoraport','+9536374169153','+8415109290664','damon.zboncak@rutherford.biz','lspencer','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(87,'Lebsack, Thiel and Walsh','nok','Inverse optimal software','Tianna Green','546 Eino Trace Suite 285','90908','North Aditya','+2780538133724','+4720445027515','gertrude44@konopelski.net','collier.adah','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(88,'Zemlak LLC','nok','Profit-focused leadingedge utilisation','Roob Highway','37340 Bergstrom Junction','59558','Trompfort','+4291049372622','+2726731358384','wrolfson@lueilwitz.com','stanton.asha','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(89,'Brakus and Sons','ok','Versatile stable instructionset','Deja Views','6861 Franco Hollow Apt. 903','94871','West Alfhaven','+3079037067832','+6188287648344','mkessler@cassin.com','lowell.zulauf','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(90,'Bednar-Barrows','ok','Assimilated explicit projection','Nikolaus Pine','2964 Braun Divide Suite 633','18124-2354','McGlynntown','+1049369459439','+4780672940983','feeney.candido@bins.com','yjerde','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(91,'Kris, Smith and Mertz','nok','Polarised executive adapter','Kuphal Row','1298 Dorothea Mountains Apt. 101','58124-8429','East Drakeview','+7347518498661','+0148179657216','alycia.cartwright@greenfelder.biz','jamir58','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(92,'Weissnat-Abbott','ok','Public-key secondary firmware','Daugherty Mills','462 Larkin Ramp Apt. 177','98934-6265','Danikamouth','+0341083638594','+7073634707169','oreilly.krystina@lubowitz.com','schimmel.assunta','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(93,'Emard Inc','ok','Virtual attitude-oriented definition','King Manors','64898 Collier Avenue','98185-5570','Port Emmanuelfort','+3724244680267','+3364875855976','qmckenzie@cremin.com','lmraz','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(94,'Robel, McDermott and Lubowitz','ok','Stand-alone national paradigm','Mallie Falls','618 Brown Mountains Suite 349','28006','Port Rogers','+4117818769468','+1216161009658','deja.mccullough@hintz.info','lockman.mitchel','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(95,'Friesen and Sons','nok','Enterprise-wide homogeneous website','Bins Freeway','1787 Mariano Well Apt. 178','23652-7262','North Ewellfort','+3591627664653','+8632905207111','theodora33@ritchie.biz','vjast','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(96,'Wyman-Mitchell','ok','Open-architected needs-based capability','Brekke Burg','2644 Kiera Track','18636-5672','West Freddieberg','+5810044026697','+8309338261118','alexzander28@bailey.com','ghodkiewicz','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(97,'Breitenberg LLC','ok','Operative executive solution','Kraig Branch','114 Gutmann Circle Suite 073','19970-4965','Ankundingfort','+2042082744861','+9817002921616','dubuque.leilani@mertz.com','dangelo.osinski','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(98,'Boyer, Balistreri and Hessel','nok','Distributed user-facing encryption','Shanon Highway','2755 Becker Crossroad','53686','Myrnaberg','+8254738541729','+9168794319178','orn.meghan@bailey.net','claudine18','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(99,'Rowe-Hayes','ok','Profit-focused user-facing info-mediaries','Maci Plaza','87252 Russel Valleys','50830','East Brandi','+2977325744405','+0578167945491','doyle.danny@robel.org','dante.hyatt','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(100,'Greenholt, Mills and Oberbrunner','ok','Universal analyzing concept','Jamir Circles','53230 Saige Plain Suite 509','56406-5776','Port Lacyburgh','+4184474762712','+7212806800215','noble13@watsica.com','weissnat.reanna','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(101,'Wehner, Murazik and Nolan','ok','Horizontal uniform hierarchy','Alanna River','5004 Al Camp Apt. 994','80442-3140','Jerrymouth','+1754960568825','+2268637463506','easter07@metz.com','raymundo13','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(102,'Turcotte and Sons','nok','Horizontal intangible interface','Block Locks','697 Cassin Field','97958','New Angelineview','+1912128289311','+0438695636913','kreiger.lonnie@feeney.com','kendall68','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(103,'Rempel, Pfannerstill and Koss','ok','Devolved bifurcated complexity','Wintheiser Harbors','3656 Micheal Crossroad','45159-9142','Samantabury','+2451208959268','+3083151704722','lonie02@rodriguez.com','toney34','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(104,'Kirlin LLC','nok','Customer-focused grid-enabled access','Labadie Roads','868 Lenore Burgs Suite 131','27248-3778','Erinborough','+5892474361908','+4241964541858','amara45@olson.com','rogahn.alessandro','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(105,'Barrows Ltd','nok','Re-contextualized motivating GraphicInterface','Schoen Ways','8752 Petra Orchard Suite 076','72244','Port Jovanyport','+0572638405261','+3903022235864','corwin.myrtie@hauck.com','jett02','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(106,'Nitzsche Ltd','ok','Cross-group 6thgeneration superstructure','Price Freeway','34940 Esperanza Walks Suite 236','79609-7024','Buckridgeburgh','+7497883534875','+4741083780873','una.christiansen@romaguera.com','sincere36','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(107,'Kihn Inc','ok','Compatible modular instructionset','Kshlerin Forge','915 Nitzsche Viaduct Apt. 094','49008','Anselstad','+1645586185793','+2194016584609','bturner@lehner.com','bgrimes','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(108,'Little, Green and Shanahan','nok','Open-source needs-based instructionset','Sean Lakes','696 Lemke Road','75910-2561','East Kolby','+7788577147820','+2838422879951','candida31@schaden.biz','wbode','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(109,'Kunze-Gusikowski','nok','Multi-lateral encompassing instructionset','Witting Port','66475 Keeling Estates Apt. 340','53205-7944','Gottliebtown','+9191209927135','+5143743262038','nathan90@denesik.com','kshlerin.rupert','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(110,'Schoen, Greenfelder and Luettgen','ok','Synergized zerotolerance standardization','Armand Estate','18112 Torp Squares Apt. 842','76392-5849','North Kian','+8104140366886','+1692912003039','jensen.stracke@rolfson.com','cordell35','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(111,'Bosco Ltd','ok','Organic exuding synergy','Jarod Canyon','1893 Cornell Common','05800','Elenaport','+5263344496765','+1279091660482','okuneva.hannah@durgan.com','pedro.senger','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(112,'Hessel, Crist and Ortiz','nok','Switchable responsive access','Leonor Ford','290 Lydia Manor','08980','Lake Cleveland','+9181406555853','+9454196825314','addie46@west.com','hammes.ova','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(113,'Weber LLC','ok','Organic executive circuit','Trenton Station','6705 Littel Lock Suite 281','66684','South Maymouth','+6766926156258','+5358691348256','epfannerstill@herman.com','mbalistreri','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(114,'Ryan LLC','nok','Assimilated leadingedge leverage','Littel Shoals','455 Pollich Pike Apt. 171','15750-3696','Grahamstad','+4182611017480','+8759140865591','rcollier@shanahan.com','ullrich.emory','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(115,'Harber and Sons','nok','Persevering mission-critical installation','Kohler Stravenue','413 Hailie Trafficway Suite 887','53489','West Macyberg','+2322466614498','+9982323884149','herman.arvid@cole.info','odessa05','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(116,'Johnston Group','ok','Triple-buffered multimedia parallelism','Abbott Villages','1302 Alvah Mission','30438-3589','Elainafurt','+2272241388226','+2763438787819','bill96@lubowitz.com','dicki.annetta','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(117,'Stamm, Herzog and Roob','nok','Multi-layered uniform instructionset','Will Field','4937 Alanis Ville','30504-0508','West Bertchester','+9016394646467','+1849855291199','edna29@boyle.org','irma31','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(118,'Schmitt, Gutmann and Corwin','nok','Devolved mission-critical superstructure','Riley Flats','7858 Morton Corners Suite 730','31514-2504','East Hershelberg','+9452917175472','+2898429125054','wshanahan@rodriguez.com','eunice.smitham','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(119,'Heller, Baumbach and Boyle','nok','Proactive tangible superstructure','Ladarius Course','5076 Morar Dam','70161','Port Geovanyshire','+1718814253469','+2336364246337','ayden.batz@bashirian.biz','littel.joelle','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(120,'Feeney, Christiansen and Considine','nok','Universal analyzing protocol','Morar Cove','6878 Maria Stream','56517','Lake Clementfurt','+7676789192606','+1155753399534','cremin.nickolas@ondricka.com','htorp','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(121,'King-Deckow','nok','Mandatory eco-centric internetsolution','Pfeffer Shoals','8490 Davonte Prairie','95988','Boehmtown','+2442436648572','+6920160324236','francesca96@gottlieb.net','marks.alfredo','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(122,'Schowalter, Eichmann and Jacobi','ok','Persistent real-time time-frame','Fahey Mall','4858 Jabari Knoll Apt. 565','31426','Stokesside','+8484704958603','+2598460460669','miles.hudson@cassin.com','darius.sawayn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(123,'Raynor PLC','ok','Expanded intermediate array','Ernest Lodge','2865 Rosa Way','48302','East Lessiemouth','+1383911828461','+0156625754148','horacio.daniel@stiedemann.biz','macie55','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(124,'Ebert-Jones','nok','Organized homogeneous conglomeration','Swaniawski Views','407 Jude Knoll Suite 549','02345','Stuartmouth','+9800649580223','+5346238138855','gusikowski.maud@hamill.com','carmela58','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(125,'Wilderman, Kulas and Jerde','ok','Upgradable solution-oriented capability','Garnet Mill','4235 Windler Plaza','37477','Eileenton','+2424554770424','+0976959494639','gheller@reichert.com','yterry','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(126,'Hermiston, Nikolaus and Ritchie','ok','Advanced client-server firmware','Heidenreich Ramp','19042 D\'Amore Mountains Suite 774','88537-0506','Langmouth','+9144011272359','+9896130641032','lucienne.adams@mcclure.biz','kblock','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(127,'Kris, Franecki and Connelly','nok','Extended neutral time-frame','Kertzmann Point','879 Dorris Points','38399','Pfannerstillburgh','+8305294958494','+3394290724451','schoen.odessa@king.org','dovie.veum','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(128,'Turcotte, Koelpin and Kuhic','ok','Ameliorated demand-driven hub','Huels Manors','24048 Lennie Shore','55822-3942','Simmouth','+8649382164458','+7123281180253','hermina28@eichmann.com','jdibbert','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(129,'Adams-Ondricka','nok','Re-engineered global GraphicalUserInterface','Ian Estates','5434 Reynolds Green','60730-0019','South Kaleshire','+9188838178916','+2297753779638','rice.karlie@hoeger.com','wilhelm96','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(130,'Walsh-Monahan','ok','Upgradable local moderator','Lehner Flat','5522 Cruickshank Locks','81174','Medhurstberg','+5758293355904','+5817772052604','amaya.wilkinson@okuneva.com','hettinger.bethel','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(131,'Grimes LLC','nok','Managed scalable interface','Hahn Prairie','87625 Daryl Vista','50079','North Amelymouth','+4510038142359','+1835500345506','vandervort.adam@powlowski.com','melody86','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(132,'Swaniawski, Pacocha and Watsica','ok','Extended eco-centric knowledgebase','Durward Corner','45128 Ankunding Corners','46956-2121','East Kipville','+7992764997427','+2328419858024','cora.swaniawski@mccullough.info','tbecker','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(133,'Goldner PLC','nok','Cross-group even-keeled service-desk','Stiedemann Bypass','7407 Marjorie Mall','39159-8291','New Enola','+5899581834947','+0083638355203','sierra.ferry@strosin.net','rdibbert','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(134,'Schaden Group','ok','Advanced system-worthy application','Ernestine Light','8386 Christelle Plains','92273-7316','Koeppton','+6156748250987','+8576469540071','jadon58@ernser.com','dickens.domenica','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(135,'Shields-Windler','ok','Implemented directional architecture','Reinhold Viaduct','755 Marcelina Spurs','75860','Funkland','+8299345677550','+3092334232462','cormier.oran@larkin.com','kory.stehr','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(136,'Satterfield-Jerde','ok','Re-contextualized optimal data-warehouse','Mills Ferry','63718 Samir Walks','54402-8804','Angiefurt','+5153977127133','+0864048877908','jbergstrom@von.info','joe06','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(137,'Brown Group','ok','Enhanced executive parallelism','Marvin Ridge','2367 Cade Alley','51640-3754','Roobberg','+5403775168869','+2879536652830','krista70@haag.com','collier.stanley','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(138,'Stiedemann, Weber and Collins','nok','Fundamental system-worthy function','Brown Fork','88007 Kemmer Dam','97422-5690','North Eileenfort','+0596863846840','+8139679317120','wschumm@hagenes.com','otto89','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(139,'Lakin, Kreiger and McClure','nok','Reduced mission-critical time-frame','Senger Row','413 Dillon Path','48460-1233','Port Caroline','+9854263954681','+1314240384441','audra38@mraz.com','connelly.monty','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(140,'Maggio, Towne and Bergstrom','nok','Right-sized web-enabled parallelism','Jordy Burgs','96006 Altenwerth Drive Suite 971','29169','Port Ariel','+1459245005863','+5820440641363','mjaskolski@connelly.com','mohr.kiley','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

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
	(1,'murray','Rutherford Cliff','279 Hoppe Falls','23540-0614','New Cecile','+1269712525548','+7331319061261','kautzer.lilly@pfeffer.info',2,'pleffler','2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(2,'bayer','Crystal Inlet','67860 Pollich Ferry Suite 699','21576','Jermainebury','+9270538545275','+4433644337552','vidal.hermann@kirlin.net',6,'vivian07','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'reichert','Kirlin Point','832 Hudson Wells','03205','McCulloughfurt','+7461551254522','+3808482385015','meagan.pfannerstill@carroll.net',10,'eanderson','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'sanford','Effie Ranch','95913 Reinger Meadow Apt. 113','96160','Lake Kaseyland','+8594678257797','+8853263593198','chand@johns.com',14,'keagan.volkman','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'russel','Robel Pines','69544 Ramon Isle','90771','South Jordaneside','+6872030573631','+0587384940953','ufahey@carter.com',18,'gulgowski.adell','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(6,'quitzon','Mario Junctions','79623 Mertie Harbors Apt. 626','63130','Reinholdhaven','+8394912705309','+9166340555637','crystal52@lockman.com',22,'goyette.alford','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(7,'grady','Rahul Walks','690 Roosevelt Inlet Suite 939','21688','Lake Cordie','+0244751985031','+3213772471126','collins.dagmar@macejkovic.com',26,'pwintheiser','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(8,'nikolaus','Cronin Valleys','169 Conroy Points','80262','North Sallie','+8157056637220','+2059272343470','raven.lakin@schowalter.com',30,'dare.helene','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(9,'williamson','Baumbach Knolls','429 Jaleel Route','41326-5054','Bradtkeville','+6456353074008','+4215027043859','nemmerich@harvey.com',34,'eliezer83','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(10,'stokes','Weissnat Isle','50761 Ullrich Divide Apt. 022','25655-8372','Williamsonland','+7795221841177','+5707339039804','sawayn.bette@harris.biz',38,'estefania95','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(11,'adams','Sanford Unions','72667 Evie Court','78560-4445','Emilbury','+8263342194628','+2466272435279','astracke@heathcote.org',42,'florine.vandervort','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(12,'considine','Dillon Course','3387 Alayna Stream','15436-3351','Antoinetteview','+9047213178661','+8481069935898','hickle.daisha@steuber.org',44,'msatterfield','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(13,'heller','Klein Lights','1823 Deckow Mountain Apt. 203','74378','McLaughlinland','+4543713945621','+0427518522707','ishields@kiehn.org',46,'emilie90','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(14,'ebert','Percy Highway','24588 Batz Trail','44090-3950','Noelstad','+9088982369108','+9634694869271','micah.botsford@towne.org',49,'denis.waters','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(15,'cummerata','Raheem Trafficway','82021 Turner Junction Apt. 914','51712-5181','East Myastad','+7402513733474','+3877500027771','aufderhar.earline@predovic.biz',51,'cheyenne.mertz','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(16,'streich','Fadel Village','3654 Amari Island Suite 189','67796','Port Mariela','+4118407198866','+9775715205528','efrain.flatley@emmerich.net',53,'amelia.cummings','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(17,'kirlin','Jayden Forest','76168 Henderson Light Suite 923','77356','Port Gus','+1999252669186','+5217962635052','harber.hershel@mcdermott.com',56,'gloria90','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(18,'paucek','Jaren Rue','4670 Harris Garden Apt. 953','25755-2667','Jerroldside','+5220847813969','+5615844974270','jerde.dortha@conn.info',58,'jwilderman','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(19,'larkin','Wilmer Circle','891 Ken Tunnel','24852','West Marlen','+2263232299234','+2343176731567','nbernier@daniel.com',60,'zdubuque','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(20,'little','Aiyana Shoals','14451 Rodrick Meadows Suite 659','48594','Maryambury','+3161978849739','+8706774043153','mreichert@conn.com',63,'freeda.jaskolski','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(21,'bernhard','Skiles Shores','34916 Cindy Landing','06073','Port Jazmynmouth','+3990337191705','+8404851639101','klein.cielo@koelpin.info',65,'zula.will','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(22,'fisher','Lehner Ranch','860 Hills Forks','27894-0213','Thieltown','+1450382506924','+2125463379378','dalton77@schoen.biz',67,'ludwig05','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(23,'schoen','Homenick Falls','69737 Sauer Forks','94378','Wildermantown','+1761412507149','+8803918477918','cquitzon@mosciski.com',70,'vmurazik','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(24,'robel','Hintz Mall','5195 Laurel Brook','12482-2944','South London','+5663466659107','+6177457738069','langworth.kevon@powlowski.org',72,'ilene16','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(25,'pollich','Crist Isle','1743 Kennedi Island','12590-2364','South Quinn','+2836489875344','+4848217972253','clyde27@shanahan.com',74,'jade.konopelski','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(26,'block','Ernser Skyway','30667 Parker Square Apt. 170','25659-6250','Lake Nikki','+4253763337786','+5571954840614','mueller.clair@kerluke.com',77,'daniella95','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(27,'koss','Linda Ferry','976 Grady Park','47179','Brennastad','+0115660883034','+7868477243557','lila12@krajcik.com',79,'harvey23','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(28,'langosh','Dare Turnpike','579 Maxime Springs Suite 609','24028-0140','New Margarete','+6988390084151','+5781360529213','ythiel@dietrich.com',81,'kuhic.carolyn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(29,'hilpert','Robbie Square','2718 Will Landing Suite 627','89204-0055','Natburgh','+2004119315216','+3579999362842','ozella.lind@orn.com',84,'lois.dicki','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(30,'jenkins','Sylvia Dam','9719 Hettie Stream Suite 239','31174-0661','Gerholdtown','+1802097975075','+8941565522698','arice@spinka.com',86,'grant.velda','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(31,'senger','Myrl Forest','529 Alvera Course Suite 552','24056','Morarhaven','+4843522648056','+7459847439155','pwilderman@batz.com',88,'qyost','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(32,'ernser','Kuvalis Forges','900 Feil Lake Suite 882','61138-7696','West Vidal','+4281389693306','+8756474497632','thiel.alexis@heidenreich.com',91,'mheidenreich','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(33,'funk','Cremin Circle','135 Monahan Point','52601','South Tinaville','+5740497318168','+9996544522030','reanna.goyette@zboncak.com',93,'hauck.kobe','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(34,'kuhn','Cleveland Run','80613 Holden Fort','93161','Nonahaven','+3724683768618','+6245390077909','chilll@schroeder.com',95,'reilly.chesley','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(35,'schiller','Yesenia Rue','72885 Gabriel Plains','97803','Flavioville','+2224150431032','+5567450460444','blanda.treva@pollich.com',98,'ytorp','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(36,'fisher','Corkery Causeway','322 Emile Landing Suite 418','82207','South Hulda','+6626948280876','+4771063312556','ksatterfield@lang.com',100,'michele.batz','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(37,'gottlieb','McDermott Isle','38719 Rebeka Light Suite 658','69806-9035','East Marcelinomouth','+6901896671969','+8624059951977','gulgowski.angelica@ullrich.com',102,'ferry.lelia','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(38,'windler','Libbie Islands','24859 Bogisich Roads','90571-9338','Klington','+6547433534094','+1761227365501','rosalia12@kilback.info',105,'ystanton','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(39,'terry','Spinka Circle','291 Thalia Points','32619','Jeremyfort','+1218740102244','+4404756197350','kihn.muhammad@oconner.org',107,'adell.block','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(40,'marvin','Ines Branch','8252 Turner Trafficway Suite 307','52193-7397','Marietown','+8800054948969','+9883539486817','jeanne90@bednar.com',109,'areichert','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(41,'stiedemann','Dedrick Point','1363 Ansley Parkways Suite 755','74000-3236','North Madisen','+3268510850421','+7334204300447','wyman.felipe@wunsch.com',112,'dach.dillan','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(42,'deckow','Zelma Rue','38347 Herman Tunnel','18036-3382','Port Lee','+5478512446396','+6772674255345','medhurst.evert@huels.org',114,'kailey.sawayn','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(43,'kautzer','Littel Ferry','22519 Elias Well','84731-6750','North Imogene','+7253802794398','+5246871753612','mante.virgil@renner.info',116,'pearl18','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(44,'nader','Zetta Hills','6871 Macejkovic Square Suite 627','89025-0800','West Rozellaland','+3553426371770','+7534623718079','lrohan@cronin.com',118,'lehner.may','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(45,'leannon','Blick Mill','178 Schmitt Plain Suite 746','28271-0113','Lake Crawfordberg','+3284250222618','+1463156034984','henriette.fahey@kuvalis.com',120,'veum.rowland','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(46,'upton','Zula Port','1265 Lebsack View','77373-7537','Sauerburgh','+7077515132044','+4067653357134','fred.will@donnelly.com',122,'brekke.alf','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(47,'veum','Feeney Oval','623 Larkin Fall','33768','South Briceville','+0763963304622','+2236741082441','turner.harmony@hane.biz',124,'yzemlak','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(48,'renner','Raegan Brook','2528 Monique Knoll Suite 471','02774-6802','McDermottland','+4967430544802','+2188553857618','glubowitz@brekke.com',126,'shanahan.vito','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(49,'mraz','Parker Shoals','5709 Lynch Walks','41596-3694','Port Bradshire','+6197092895214','+0388208505369','smith.ray@metz.net',128,'olga48','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(50,'renner','Shields Circle','2387 Buckridge Hill Suite 294','29291-7050','East Trey','+8041429726004','+2324436804531','bosco.luis@stroman.com',130,'jkirlin','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(51,'romaguera','Green Lane','20223 Kiehn Lakes Suite 034','36344','Legrosstad','+5699242239204','+7779252618053','grace36@nitzsche.biz',132,'cturcotte','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(52,'zieme','Vandervort Loaf','744 Hansen Grove Suite 113','83176','Gleasonport','+6834642042346','+5051587579880','jacobi.myrl@leuschke.com',134,'charles.schimmel','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(53,'schinner','Langworth Bypass','1802 Leanne Vista','24391-7883','Mayerhaven','+6011126701989','+7459177687195','shea98@lemke.com',136,'welch.lawson','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(54,'welch','Maurice Isle','37649 Jensen Turnpike','94145-9627','Hodkiewiczborough','+2589554882493','+5369077330600','vwyman@kuhlman.com',138,'leone63','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(55,'vonrueden','Mueller Canyon','31719 Dannie Extensions','92836-3824','North Anya','+3573071621567','+0017703021264','angelica27@brakus.info',140,'green.norval','2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;

INSERT INTO `deliveries` (`id`, `order_id`, `delivery_contact_id`, `created_at`, `updated_at`)
VALUES
	(1,1,13,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(2,2,16,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(3,3,19,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(4,4,22,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(5,5,25,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(6,6,28,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(7,7,31,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(8,8,34,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(9,9,37,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(10,10,40,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(11,11,43,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(12,12,46,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(13,13,49,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(14,14,52,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(15,15,55,'2017-05-26 08:08:01','2017-05-26 08:08:01');

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
	(1,'Labore quas odit voluptas et. Sunt mollitia libero eius a itaque saepe culpa. Consequatur quia amet facilis aliquid. Dignissimos eaque mollitia totam quas odit.',1,23,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(2,'Culpa provident ipsam in adipisci tempora. Recusandae officiis tempora laboriosam quo inventore ut. Aut quasi quidem exercitationem sint maiores. Ut ipsam eius repellendus quia nisi.',2,26,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(3,'Id impedit repellat rem vero dolorem expedita est nihil. Dolorem et enim sit fugiat facilis ut itaque. Natus sit rerum voluptates sequi. Est quos quis iure sint.',3,29,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(4,'Rerum ipsa impedit labore culpa et enim voluptas. Est sequi quas consequatur quidem suscipit.',4,32,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(5,'Quos sed dolor modi eaque tempore nihil quia corrupti. Quidem esse qui et aut voluptas. Magni nesciunt laudantium consequatur reprehenderit nulla repellat autem hic. Quia nisi quibusdam sit quaerat iure deserunt dolor.',5,35,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(6,'Sequi ab qui placeat temporibus. Repudiandae accusamus dolorem est. Rerum sit sint consectetur illo at qui. Ducimus id nihil molestiae repellendus. A non omnis dolor veniam corporis corporis dolor.',6,38,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(7,'Nulla voluptas omnis voluptas repudiandae enim quod. Nihil expedita aperiam similique assumenda. Atque molestias aspernatur voluptas natus dolorem eligendi. Impedit aut voluptatem ipsa dolorum nihil tempore.',7,41,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(8,'Aliquid aut ducimus praesentium deleniti. Omnis itaque deserunt maxime aspernatur. Deserunt consequatur quis pariatur ut.',8,44,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(9,'Hic praesentium enim ut velit. Est aut sed saepe ea et. Illo adipisci ullam sapiente nisi similique molestiae.',9,47,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(10,'Non in iste odit labore. Facere molestias iste quasi porro nobis nostrum aut. Modi et harum ut ipsam voluptatem suscipit. Rerum iusto hic dolorem rem voluptatibus velit officiis.',10,50,'2017-05-26 08:08:01','2017-05-26 08:08:01');

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

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;

INSERT INTO `documents` (`id`, `file_name`, `file_path`, `mime_type`, `quantity`, `rolled_folded_flat`, `length`, `width`, `nb_orig`, `free`, `format_id`, `delivery_id`, `main_article_id`, `option_article_id`, `created_at`, `updated_at`)
VALUES
	(1,'9794019274224.sit','/path/to/file/','application/x-sv4cpio',77,'flat',67,10,1,0,1,11,1,NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(2,'9797437349802.semd','/path/to/file/','application/x-gtar',94,'flat',8,79,5,1,2,12,2,NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(3,'9791756108102.mpp','/path/to/file/','application/vnd.oasis.opendocument.text-web',61,'flat',15,3,4,1,3,13,3,NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(4,'9790580177841.mp4a','/path/to/file/','image/webp',12,'flat',31,14,4,0,4,14,4,NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01'),
	(5,'9782811982645.vxml','/path/to/file/','application/vnd.lotus-1-2-3',37,'rolled',31,27,3,1,5,15,5,NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01');

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
	(1,'lueilwitz',81,15,95205.00,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(2,'torphy',99,77,54760.00,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'shields',32,1,7753.00,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'swaniawski',3,43,39039.00,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'aufderhar',94,76,31023.00,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

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
	(771,'2014_10_12_000000_create_users_table',1),
	(772,'2014_10_12_100000_create_password_resets_table',1),
	(773,'2017_05_09_163758_create_businesses_table',1),
	(774,'2017_05_09_172315_create_companies_table',1),
	(775,'2017_05_09_173405_create_contacts_table',1),
	(776,'2017_05_09_185357_create_orders_table',1),
	(777,'2017_05_10_084559_create_formats_table',1),
	(778,'2017_05_10_085200_create_categories_table',1),
	(779,'2017_05_10_085535_create_articles_table',1),
	(780,'2017_05_10_090336_create_documents_table',1),
	(781,'2017_05_10_141954_create_business_comments_table',1),
	(782,'2017_05_10_142209_create_delivery_comments_table',1),
	(783,'2017_05_10_142429_create_deliveries_table',1),
	(784,'2017_05_10_145628_add_foreign_keys_articles_table',1),
	(785,'2017_05_10_163217_add_foreign_keys_business_comments_table',1),
	(786,'2017_05_10_164835_add_foreign_keys_businesses_table',1),
	(787,'2017_05_10_165804_add_foreign_keys_contacts_table',1),
	(788,'2017_05_10_172845_add_foreign_keys_deliveries_table',1),
	(789,'2017_05_10_173205_add_foreign_keys_delivery_comments_table',1),
	(790,'2017_05_10_173543_add_foreign_keys_documents_table',1),
	(791,'2017_05_10_181450_add_foreign_keys_orders_table',1),
	(792,'2017_05_18_130838_add_foreign_keys_users_table',1);

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
	(1,'81921825','nok',11,12,22,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(2,'49826854','nok',12,15,25,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'97668309','ok',13,18,28,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'12538854','nok',14,21,31,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'87672858','nok',15,24,34,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(6,'94438850','nok',16,27,37,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(7,'79869821','nok',17,30,40,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(8,'57976877','ok',18,33,43,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(9,'20672818','nok',19,36,46,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(10,'73207970','ok',20,39,49,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(11,'36167214','ok',21,42,52,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(12,'86825419','ok',22,45,54,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(13,'59087549','nok',23,48,56,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(14,'22561623','nok',24,51,58,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(15,'58086805','ok',25,54,60,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

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
  `role` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_validated` tinyint(4) NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `email_validated`, `firstname`, `lastname`, `company_id`, `remember_token`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'fahey.edward','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','zrippin@example.org',1,'Camille','Armstrong',3,'exG5kqPuLr',NULL,'2017-05-26 08:08:00','2017-05-26 08:08:00',NULL),
	(2,'carmella.grant','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','demetrius10@example.org',1,'Alysson','Durgan',4,'qFIv21mvTN',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(3,'amalia22','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','myra.streich@example.net',1,'Amely','Wisoky',7,'OHEv06VkAu',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(4,'ohaley','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','elwyn.ullrich@example.net',1,'Ashly','Kub',8,'GG4rHF8kbl',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(5,'pat86','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','lvandervort@example.com',1,'Barney','Stanton',11,'aLDCqAlYtw',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(6,'danny60','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','crist.raleigh@example.com',1,'Keeley','West',12,'Xvdcl4OZW6',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(7,'skeeling','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','genevieve31@example.com',1,'Rahul','Hilll',15,'SMJyPg91uo',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(8,'qdubuque','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','dklein@example.org',1,'Mckenna','Nienow',16,'gdjcxDc9n7',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(9,'zbeatty','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','farmstrong@example.net',1,'Rhiannon','Klein',19,'MW5V89yQh4',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(10,'koss.william','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','mlangworth@example.org',1,'Terrill','Ziemann',20,'cVU6w4LJjC',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(11,'glarson','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','zthompson@example.org',1,'Helmer','Tremblay',23,'70j0H4BDS3',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(12,'skyla47','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','kim13@example.com',1,'Clifford','Hessel',24,'y53Tl7eqht',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(13,'shemar.green','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','bruen.elwyn@example.net',1,'Estel','Hegmann',27,'CR7KhWaNQ2',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(14,'arlie.rippin','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','bailey.lamont@example.com',1,'Lue','Beatty',28,'SHVESpiNGW',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(15,'okertzmann','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','skiles.alek@example.org',1,'Janessa','Hilpert',31,'a8XaKt1ypL',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(16,'tyrese66','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','pmurazik@example.net',1,'Fern','McClure',32,'Jfs1YsP4H5',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(17,'enikolaus','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','glover.durward@example.com',1,'Gabriella','Hermiston',35,'R22ixEQ2zy',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(18,'buckridge.riley','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','twila77@example.com',1,'Joy','Monahan',36,'vpSZipXDMz',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(19,'ujacobi','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','kristin.fadel@example.net',1,'Katheryn','Schulist',39,'W0U2mhnkaa',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(20,'gmiller','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','phaag@example.org',1,'Torey','Gibson',40,'Tgve2zheJy',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(21,'veum.skye','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','keanu95@example.org',1,'Gloria','Haag',43,'3VLCOZnR6d',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(22,'zjaskolski','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','mustafa17@example.org',1,'Rae','Schmidt',45,'rbvjnp4xxb',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(23,'barney.mayer','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','angelina.miller@example.net',1,'Elsa','Stroman',47,'aaBrBG4tAG',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(24,'borer.liana','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','melyna.mcdermott@example.org',1,'Emelie','Jacobs',50,'ZMkejWTIuA',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(25,'destiny.cremin','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','ifadel@example.org',1,'Dolores','Wisozk',52,'GQLtKOwSUF',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(26,'norberto96','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','aurelia96@example.org',1,'Nigel','Gutkowski',54,'lviyz5o8No',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(27,'nikolaus.merle','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','kmayer@example.org',1,'Kaelyn','Gleichner',57,'lSw5cRbMf3',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(28,'umoen','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','kshlerin.ocie@example.com',1,'Danielle','Romaguera',59,'usNuSog3sH',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(29,'matteo.monahan','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','ida48@example.com',1,'Lydia','Lebsack',61,'PIgfVRF7Zc',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(30,'alfonso.connelly','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','kulas.justyn@example.org',1,'Josianne','Kiehn',64,'WAWbKeZcoC',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(31,'uarmstrong','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','marcia.johns@example.com',1,'Madonna','Mills',66,'RfonLMm3DZ',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(32,'kovacek.isabelle','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','jenifer.sipes@example.net',1,'Hershel','Altenwerth',68,'nCb2SWvAQe',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(33,'nvon','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','harley.harris@example.com',1,'Neal','Yundt',71,'onN8SKjPim',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(34,'isidro29','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','zmueller@example.org',1,'Steve','Trantow',73,'vRBQ63NvZK',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(35,'marilyne.veum','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','goldner.juliana@example.com',1,'Concepcion','Ryan',75,'MFbelUI2IM',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(36,'upton.grayson','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','benny.hettinger@example.com',1,'Willis','Ryan',78,'ZlhhOt1xAO',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(37,'imorissette','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','ngutkowski@example.com',1,'Fermin','Mayer',80,'QxEcNaMmMD',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(38,'nitzsche.kadin','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','meda.mccullough@example.org',1,'Dana','Bauch',82,'XvFBuYiIG2',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(39,'pagac.major','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','jlowe@example.org',1,'Karlee','Runolfsson',85,'IhGp5C375V',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(40,'aimee00','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','yasmine52@example.net',1,'Quinn','McGlynn',87,'mhLllZ3pay',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(41,'jeanie63','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','sydnie.ullrich@example.org',1,'Hassan','Zulauf',89,'EzuDViGRSD',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(42,'maxine64','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','lind.willie@example.net',1,'Seamus','Pagac',92,'AKPzls7KQi',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(43,'myrtis35','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','coty46@example.net',1,'Brycen','Cassin',94,'XhdsTqHkOq',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(44,'lizeth28','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','kailey.langworth@example.com',1,'Price','Monahan',96,'D6prlGIqDJ',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(45,'mitchel85','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','hodkiewicz.austyn@example.com',1,'Francesca','Schimmel',99,'HLj519rc0c',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(46,'qbalistreri','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','hoppe.tracy@example.com',1,'Hortense','Fay',101,'iPBFn0e3O6',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(47,'cartwright.marcelo','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','sven51@example.com',1,'Ford','O\'Keefe',103,'UjqgrtUcqt',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(48,'idibbert','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','feeney.adrienne@example.org',1,'Laury','Yundt',106,'RFzaHXTYnc',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(49,'mertz.sterling','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','igutkowski@example.org',1,'Clay','Schroeder',108,'OluO54Q6FK',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(50,'towne.erica','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','ijenkins@example.org',1,'Graciela','Leffler',110,'PKSAiZEFfj',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(51,'nayeli63','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','carter.afton@example.org',1,'Nicole','Hauck',113,'xuHI1EJYTh',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(52,'kutch.caroline','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','zackary01@example.com',1,'Aliyah','Weissnat',115,'XlwgcD1Wvs',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(53,'kolby.boehm','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','finn46@example.com',1,'Angel','Terry',119,'3YbW3cC9wX',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(54,'noreilly','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','marlon47@example.net',1,'Gracie','Stanton',121,'kibvRreGj1',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(55,'king.kuhic','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','lukas.turcotte@example.org',1,'Kacie','Nikolaus',125,'LDDtUFDLtQ',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(56,'desiree93','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','user','cprosacco@example.net',1,'Maggie','Corkery',127,'Jf5flDCghR',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(57,'aron.harvey','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','maryam13@example.com',1,'Freida','Senger',131,'sOf4hnuH4A',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(58,'urobel','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','melisa70@example.net',1,'Lizeth','Jacobson',133,'sp1ByDQN4u',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(59,'yasmeen36','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','jeromy.herzog@example.net',1,'Wilhelmine','Douglas',137,'IdPwB3f84b',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL),
	(60,'annabel11','$2y$10$uxTm7NouFKIJF4oseTigHu0a1YK.JGUftw5wkIytZZzkj3n5h75Ui','admin','justine.stamm@example.org',1,'Constantin','Schumm',139,'GBLfgWQklm',NULL,'2017-05-26 08:08:01','2017-05-26 08:08:01',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
