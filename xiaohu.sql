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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `answer_user` */

insert  into `answer_user`(`id`,`user_id`,`answer_id`,`vote`,`created_at`,`updated_at`) values (2,2,1,1,'2018-05-07 01:25:57','2018-05-07 01:25:57'),(3,2,3,1,'2018-05-12 02:32:41','2018-05-12 02:32:41'),(5,3,3,1,'2018-05-12 03:04:29','2018-05-12 03:04:29'),(10,3,1,1,'2018-05-12 07:04:08','2018-05-12 07:04:08'),(29,1,3,1,'2018-05-12 09:20:00','2018-05-12 09:20:00'),(35,1,8,1,'2018-05-12 09:35:41','2018-05-12 09:35:41'),(42,3,8,1,'2018-05-14 02:55:30','2018-05-14 02:55:30'),(43,3,11,1,'2018-05-15 03:27:43','2018-05-15 03:27:43'),(49,3,10,1,'2018-05-15 06:54:41','2018-05-15 06:54:41'),(61,3,4,1,'2018-05-15 07:25:09','2018-05-15 07:25:09');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `answers` */

insert  into `answers`(`id`,`content`,`user_id`,`question_id`,`created_at`,`updated_at`) values (1,'不问是不是，直接问为什么的都是耍流氓[手动微笑]',1,1,'2018-05-05 03:23:29','2018-05-05 03:23:29'),(2,'不问是不是，直接问为什么的都是耍流氓[手动微笑]',1,1,'2018-05-05 03:29:03','2018-05-05 03:29:03'),(3,'怕是个傻逼吧',1,1,'2018-05-05 03:30:08','2018-05-05 03:51:10'),(4,'红狗啊好哦高工啊哈够花',1,4,'2018-05-12 09:16:27','2018-05-12 09:16:27'),(5,'红狗啊好哦高工啊哈够花',1,5,'2018-05-12 09:16:31','2018-05-12 09:16:31'),(6,'红狗啊好哦高工啊哈够花',1,6,'2018-05-12 09:16:35','2018-05-12 09:16:35'),(7,'红狗啊好哦高工啊哈够花',1,7,'2018-05-12 09:16:38','2018-05-12 09:16:38'),(8,'红狗啊好哦高工啊哈够花',1,8,'2018-05-12 09:16:42','2018-05-12 09:16:42'),(9,'你为什么会这样？这样这样就好啦',3,3,'2018-05-14 06:39:30','2018-05-14 06:39:30'),(10,'你为什么会这样？这样这样就好啦',3,4,'2018-05-14 06:39:44','2018-05-14 06:39:44'),(11,'你为什么会这样？这样这样就好啦：）',3,22,'2018-05-14 09:09:24','2018-05-15 08:46:42'),(13,'你怎么这么皮，不皮你就不开心，皮一下就很开心是不是！！！',4,22,'2018-05-15 09:07:35','2018-05-15 09:08:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`content`,`user_id`,`question_id`,`answer_id`,`reply_to`,`created_at`,`updated_at`) values (2,'答主你好，答主再见',1,NULL,1,NULL,'2018-05-05 07:32:12','2018-05-05 07:32:12'),(3,'答主你好，答主再见',1,1,NULL,NULL,'2018-05-05 07:33:04','2018-05-05 07:33:04'),(4,'发达',3,NULL,11,NULL,'2018-05-16 03:50:12','2018-05-16 03:50:12'),(5,'曾经沧海难为水啊',3,NULL,11,NULL,'2018-05-16 03:51:37','2018-05-16 03:51:37'),(6,'你好',3,NULL,13,NULL,'2018-05-16 07:03:15','2018-05-16 07:03:15'),(7,'你说的什么',3,NULL,13,NULL,'2018-05-16 07:03:29','2018-05-16 07:03:29');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2018_05_04_014137_create_table_users',1),('2018_05_04_090053_create_table_questions',2),('2018_05_05_025932_create_table_answers',3),('2018_05_05_070320_create_table_comments',4),('2018_05_05_082735_create_table_answer_user',5),('2018_05_07_030806_add_filed_phone_captcha',6);

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `questions` */

insert  into `questions`(`id`,`title`,`desc`,`user_id`,`status`,`created_at`,`updated_at`) values (1,'为什么花儿这样红？','给你一拳你就知道了',2,'ok','2018-05-05 01:45:41','2018-05-05 02:16:53'),(2,'为什么花儿这样红？','花儿永远这么红',2,'ok','2018-05-05 02:33:24','2018-05-05 02:33:24'),(3,'为什么花儿这样红？','花儿永远这么红',2,'ok','2018-05-05 02:33:27','2018-05-05 02:33:27'),(4,'地球为什么是方的','孔子曰：天圆地方',3,'ok','2018-05-08 07:07:42','2018-05-08 07:07:42'),(5,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:14','2018-05-11 02:28:14'),(6,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:17','2018-05-11 02:28:17'),(7,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:18','2018-05-11 02:28:18'),(8,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:18','2018-05-11 02:28:18'),(9,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:19','2018-05-11 02:28:19'),(10,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:19','2018-05-11 02:28:19'),(11,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:19','2018-05-11 02:28:19'),(12,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:20','2018-05-11 02:28:20'),(13,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:21','2018-05-11 02:28:21'),(14,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:22','2018-05-11 02:28:22'),(15,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:23','2018-05-11 02:28:23'),(16,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:23','2018-05-11 02:28:23'),(17,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:24','2018-05-11 02:28:24'),(18,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:25','2018-05-11 02:28:25'),(19,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:25','2018-05-11 02:28:25'),(20,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:28:27','2018-05-11 02:28:27'),(21,'为什么花儿这样红？','花儿永远这么红',1,'ok','2018-05-11 02:43:50','2018-05-11 02:43:50'),(22,'曾经沧海难为水','曾经沧海难为水，除却巫山不是云！！！',3,'ok','2018-05-14 06:59:04','2018-05-14 06:59:04'),(23,'test1test1?','巴山夜雨涨秋池',3,'ok','2018-05-16 07:15:15','2018-05-16 07:39:41');

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
  `phone_captcha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`email`,`avatar_url`,`phone`,`password`,`intro`,`created_at`,`updated_at`,`phone_captcha`) values (1,'胡一天',NULL,NULL,'1234','$2y$10$QMJ7HjFtstadYXz/A00maOLjS.ZQZ0rHnTFqnMFA7Vi1iUJ4zDKji',NULL,NULL,'2018-05-07 03:58:56','2219'),(2,'胡一',NULL,NULL,'12345','$2y$10$Ug.iuT.7hp5FT0AhhmsP.Okq6HUH3WAXtF/5rUQbr7xkKjsLbpQIu',NULL,'2018-05-04 02:59:49','2018-05-07 02:46:52',''),(3,'test1',NULL,NULL,NULL,'$2y$10$tl9mQkB1qA9PqEBDci583OG1CRPk1CPyAREolJH6k.CvYJdemEmEC',NULL,'2018-05-08 02:44:13','2018-05-08 02:44:13',''),(4,'test2',NULL,NULL,NULL,'$2y$10$5.P7zEWhvJXuGAxE21mIweNgBrJy6iCFJ4D5pGcIevSn.fPiIN8B6',NULL,'2018-05-08 02:46:37','2018-05-08 02:46:37','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
