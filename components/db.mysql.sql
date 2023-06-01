
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `online_survey`;

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_survay` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `submits` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `s_id` (`id_survay`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


DROP TABLE IF EXISTS `survays`;
CREATE TABLE `survays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `note` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `link_vote` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `link_manage` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `views` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `survay_link_manage` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
