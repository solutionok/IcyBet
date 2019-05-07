/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 10.1.34-MariaDB : Database - betgame_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`betgame_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;

USE `betgame_db`;

/*Table structure for table `bet` */

DROP TABLE IF EXISTS `bet`;

CREATE TABLE `bet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adjudicator_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0:editing, 1:invited, 2:progress(somesone placed bet), 3:canceled, 4:completed',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

/*Data for the table `bet` */

insert  into `bet`(`id`,`adjudicator_id`,`title`,`description`,`expire`,`status`,`created_at`,`updated_at`) values 
(34,10,'bet title','Bet description','2019-05-16',1,'2019-05-07 09:30:19','2019-05-07 09:32:21');

/*Table structure for table `bet_options` */

DROP TABLE IF EXISTS `bet_options`;

CREATE TABLE `bet_options` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bet_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_answer` int(11) DEFAULT NULL COMMENT '0:no, 1:yes',
  PRIMARY KEY (`id`),
  KEY `bet_options_fk_1` (`bet_id`),
  CONSTRAINT `bet_options_fk_1` FOREIGN KEY (`bet_id`) REFERENCES `bet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

/*Data for the table `bet_options` */

insert  into `bet_options`(`id`,`bet_id`,`title`,`is_answer`) values 
(110,34,'New Option1',0),
(111,34,'New Option2',0),
(112,34,'New Option3',0);

/*Table structure for table `bet_players` */

DROP TABLE IF EXISTS `bet_players`;

CREATE TABLE `bet_players` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bet_id` int(11) DEFAULT NULL,
  `invitor_id` bigint(20) DEFAULT NULL,
  `invited_email` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `invited_name` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `invited_at` datetime DEFAULT NULL,
  `betting_option_id` int(11) DEFAULT NULL,
  `betting_at` datetime DEFAULT NULL,
  `earn_point` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bet_players_fk_1` (`bet_id`),
  KEY `invited_email` (`invited_email`(191)),
  CONSTRAINT `bet_players_fk_1` FOREIGN KEY (`bet_id`) REFERENCES `bet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

/*Data for the table `bet_players` */

insert  into `bet_players`(`id`,`bet_id`,`invitor_id`,`invited_email`,`invited_name`,`invited_at`,`betting_option_id`,`betting_at`,`earn_point`) values 
(124,34,10,'tasagents@gmail.com','Robert Michel','2019-05-07 09:32:22',NULL,NULL,NULL),
(125,34,10,'stanislav@gmail.com','Stanislav Yashin','2019-05-07 09:32:22',NULL,NULL,NULL),
(126,34,10,'daniel@gmail.com','Daniel Benuburu','2019-05-07 09:32:22',NULL,NULL,NULL),
(127,34,0,'coolpluto1114@gmail.com','kling Anton','2019-05-07 09:32:22',NULL,NULL,NULL),
(128,34,10,'nathan@gmail.com','Nathan Jacobs','2019-05-07 09:33:29',NULL,NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avata` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point` double DEFAULT NULL,
  `email_notification` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`phone`,`email_verified_at`,`password`,`avata`,`point`,`email_notification`,`remember_token`,`created_at`,`updated_at`,`closed_at`) values 
(10,'kling Anton','coolpluto1114@gmail.com','2342342341',NULL,'$2y$10$LSumCPveCKCtxlnk//F7vOjlWWT9pZOF0Nr25pRds5TWWcXkeQHZu',NULL,NULL,0,NULL,'2019-05-07 09:28:56','2019-05-07 09:38:22',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
