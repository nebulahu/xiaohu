/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.5.28 : Database - xiaohu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `answer_user` */

DROP TABLE IF EXISTS `answer_user`;

CREATE TABLE `answer_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `vote` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `answer_user_user_id_answer_id_vote_unique` (`user_id`,`answer_id`,`vote`),
  KEY `answer_user_answer_id_foreign` (`answer_id`),
  CONSTRAINT `answer_user_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  CONSTRAINT `answer_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `answer_user` */

/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_user_id_foreign` (`user_id`),
  KEY `answers_question_id_foreign` (`question_id`),
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `answers` */

insert  into `answers`(`id`,`content`,`user_id`,`question_id`,`created_at`,`updated_at`) values (1,'不问是不是，直接问为什么的都是耍流氓[手动微笑]',1,1,'2018-05-05 03:23:29','2018-05-05 03:23:29'),(2,'不问是不是，直接问为什么的都是耍流氓[手动微笑]',1,1,'2018-05-05 03:29:03','2018-05-05 03:29:03'),(3,'怕是个傻逼吧',1,1,'2018-05-05 03:30:08','2018-05-05 03:51:10');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned DEFAULT NULL,
  `answer_id` int(10) unsigned DEFAULT NULL,
  `reply_to` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_question_id_foreign` (`question_id`),
  KEY `comments_answer_id_foreign` (`answer_id`),
  KEY `comments_reply_to_foreign` (`reply_to`),
  CONSTRAINT `comments_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  CONSTRAINT `comments_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `comments_reply_to_foreign` FOREIGN KEY (`reply_to`) REFERENCES `comments` (`id`),
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`content`,`user_id`,`question_id`,`answer_id`,`reply_to`,`created_at`,`updated_at`) values (2,'答主你好，答主再见',1,NULL,1,NULL,'2018-05-05 07:32:12','2018-05-05 07:32:12'),(3,'答主你好，答主再见',1,1,NULL,NULL,'2018-05-05 07:33:04','2018-05-05 07:33:04');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2018_05_04_014137_create_table_users',1),('2018_05_04_090053_create_table_questions',2),('2018_05_05_025932_create_table_answers',3),('2018_05_05_070320_create_table_comments',4),('2018_05_05_082735_create_table_answer_user',5);

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci COMMENT 'description',
  `user_id` int(10) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ok',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_user_id_foreign` (`user_id`),
  CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `questions` */

insert  into `questions`(`id`,`title`,`desc`,`user_id`,`status`,`created_at`,`updated_at`) values (1,'为什么花儿这样红？','给你一拳你就知道了',2,'ok','2018-05-05 01:45:41','2018-05-05 02:16:53'),(2,'为什么花儿这样红？','花儿永远这么红',2,'ok','2018-05-05 02:33:24','2018-05-05 02:33:24'),(3,'为什么花儿这样红？','花儿永远这么红',2,'ok','2018-05-05 02:33:27','2018-05-05 02:33:27');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_url` text COLLATE utf8_unicode_ci,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`avatar_url`,`phone`,`password`,`intro`,`created_at`,`updated_at`) values (1,'胡一天',NULL,NULL,NULL,'$2y$10$37.38ocK8jFLn4kvANiKle9amZZY6FFyRq9c3i6P/E3x938NEI1Ie',NULL,NULL,NULL),(2,'胡一',NULL,NULL,NULL,'$2y$10$37.38ocK8jFLn4kvANiKle9amZZY6FFyRq9c3i6P/E3x938NEI1Ie',NULL,'2018-05-04 02:59:49','2018-05-04 02:59:49');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
