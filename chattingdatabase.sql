/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.14-MariaDB : Database - hcs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hcs` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `hcs`;

/*Table structure for table `ch_favorites` */

DROP TABLE IF EXISTS `ch_favorites`;

CREATE TABLE `ch_favorites` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `favorite_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ch_favorites` */

/*Table structure for table `ch_messages` */

DROP TABLE IF EXISTS `ch_messages`;

CREATE TABLE `ch_messages` (
  `id` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ch_messages` */

insert  into `ch_messages`(`id`,`type`,`from_id`,`to_id`,`body`,`attachment`,`seen`,`created_at`,`updated_at`) values 
(1737952509,'user',1,3,'hi',NULL,1,'2022-12-24 10:10:33','2022-12-24 10:10:57'),
(1762240879,'user',3,1,'i am user1',NULL,1,'2022-12-24 10:07:44','2022-12-24 10:07:56'),
(1901112294,'user',3,1,'i am sick',NULL,1,'2022-12-24 10:08:38','2022-12-24 10:08:49'),
(1922414094,'user',2,3,'hi',NULL,0,'2022-12-24 10:25:40','2022-12-24 10:25:40'),
(1927830857,'user',1,3,'hi',NULL,1,'2022-12-24 09:54:59','2022-12-24 09:59:22'),
(1993826291,'user',2,1,'hi',NULL,1,'2022-12-24 10:03:48','2022-12-24 10:04:18'),
(2123833250,'user',1,2,'hi counsellor1',NULL,1,'2022-12-24 11:12:14','2022-12-24 11:12:37'),
(2243311631,'user',4,3,'hi',NULL,1,'2022-12-24 10:14:39','2022-12-24 10:15:43'),
(2326212380,'user',1,5,'www',NULL,1,'2022-12-24 10:40:45','2022-12-24 10:41:13'),
(2328603103,'user',3,2,'hi doctor1',NULL,1,'2022-12-24 09:59:48','2022-12-24 10:01:03'),
(2375971512,'user',1,3,'sorry for late reply',NULL,1,'2022-12-24 10:10:43','2022-12-24 10:10:57'),
(2407577955,'user',1,2,'hi',NULL,1,'2022-12-24 10:03:33','2022-12-24 10:03:41'),
(2439012629,'user',2,4,'hi',NULL,1,'2022-12-24 10:26:56','2022-12-24 10:27:58'),
(2450197632,'user',3,1,'hi manager',NULL,1,'2022-12-24 10:06:18','2022-12-24 10:06:34'),
(2557517217,'user',1,3,'you must send mail to counsellor1',NULL,1,'2022-12-24 10:11:39','2022-12-24 10:11:55'),
(2606210214,'user',2,3,'hi user1',NULL,1,'2022-12-24 10:01:13','2022-12-24 10:06:03'),
(2652345490,'user',1,2,'hi  user 1 sent me email for treat',NULL,1,'2022-12-24 10:13:06','2022-12-24 11:12:37');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2022_02_05_999999_add_active_status_to_users',1),
(6,'2022_02_05_999999_add_avatar_to_users',1),
(7,'2022_02_05_999999_add_dark_mode_to_users',1),
(8,'2022_02_05_999999_add_messenger_color_to_users',1),
(9,'2022_02_05_999999_create_favorites_table',1),
(10,'2022_02_05_999999_create_messages_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('10','20','30') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patient_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('10','20','30') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`gender`,`email`,`mobile_number`,`patient_id`,`staff_id`,`email_verified_at`,`password`,`type`,`is_active`,`remember_token`,`created_at`,`updated_at`,`active_status`,`avatar`,`dark_mode`,`messenger_color`) values 
(1,'Admin','','10','admin@hcs.com',NULL,'','',NULL,'$2y$10$cqZpKjise2cmp1K/FBT46e8GLGu5fIRPhoZXswjZybYmfk/4rm3um','30','1',NULL,'2022-12-24 09:52:34','2022-12-24 10:12:09',0,'6aff6357-520f-446a-9e9b-9b5dddb2620b.jpg',1,'#2180f3'),
(2,'Counsellor 1','','10','counsellor@hcs.com',NULL,'','',NULL,'$2y$10$1Mc/aYPdAt56/HIbkw7TNuZ6T/7B6/idnkM3YrnubMcO2vbiyMZkK','20','1',NULL,'2022-12-24 09:52:34','2022-12-24 11:11:40',0,'0f87945f-f1ff-4244-bbde-233722dbd140.jpg',1,'#2180f3'),
(3,'User 1','','10','user@gmail.com',NULL,'','',NULL,'$2y$10$cm88fQlgC9/pTHU99G6alugU0imZqKScoo7OQN6fEfR7C1ehpxGgS','10','1',NULL,'2022-12-24 09:52:34','2022-12-24 10:10:03',0,'113c309a-76bd-496d-85bb-92c5f890edb0.jpg',1,'#2180f3'),
(4,'deniz','tom',NULL,'deniztom1992@gmail.com',NULL,'','',NULL,'$2y$10$.td5yBn3hwm1xlmAYF1IaupVlMA23P81ixFYE7wxld5V7rvlQEWGi','10','1',NULL,'2022-12-24 10:14:03','2022-12-24 10:44:21',0,'0b0caf81-3349-4648-8301-de710734a167.png',0,'#2180f3'),
(5,'www','www',NULL,'www@gmail.com',NULL,'','',NULL,'$2y$10$yY6VBqHb.tcMcnUaSY9WyuAaQClYOOjyfvGYk9HS4eQ06TdCLundO','10','1',NULL,'2022-12-24 10:39:42','2022-12-24 10:42:55',0,'f665ec59-1f73-4ab9-9fb2-5abb4b92d141.jpg',0,'#2180f3');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
