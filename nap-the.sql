/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : nap-the

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-08-16 15:48:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `api_token`
-- ----------------------------
DROP TABLE IF EXISTS `api_token`;
CREATE TABLE `api_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of api_token
-- ----------------------------
INSERT INTO `api_token` VALUES ('1', '4eaba7d4f5c7883af091c70b8025f3b6', '0', '2018-08-16 04:38:59', '2018-08-16 06:08:21');
INSERT INTO `api_token` VALUES ('2', 'b1f9384b345681ac627277c99b67d7a0', '1', '2018-08-16 04:39:09', '2018-08-16 04:39:09');
INSERT INTO `api_token` VALUES ('3', 'cbf46ca3e4e9bf52c7103eb9ffce034c', '1', '2018-08-16 04:39:30', '2018-08-16 04:39:30');
INSERT INTO `api_token` VALUES ('4', '6ee2abfc4f223e888e7eb77fac0524e9', '1', '2018-08-16 04:39:41', '2018-08-16 04:39:41');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2018_08_16_040111_create_api_token_token', '2');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `pay_card`
-- ----------------------------
DROP TABLE IF EXISTS `pay_card`;
CREATE TABLE `pay_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_seri` varchar(20) DEFAULT NULL,
  `card_code` varchar(20) DEFAULT NULL,
  `money_request` double DEFAULT '0',
  `money_response` double DEFAULT '0',
  `phone` varchar(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pay_card
-- ----------------------------
INSERT INTO `pay_card` VALUES ('1', '12142352346', '26672273664586', '50000', '10000', '0947911326', '0', '2018-08-15 11:00:23', '2018-08-15 11:00:23');
INSERT INTO `pay_card` VALUES ('2', '12142352346', '26672273664586', '10000', '10000', '0947911326', '1', '2018-08-15 10:25:52', '2018-08-15 10:25:52');

-- ----------------------------
-- Table structure for `phone`
-- ----------------------------
DROP TABLE IF EXISTS `phone`;
CREATE TABLE `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `money` int(11) DEFAULT '0',
  `money_change` int(11) DEFAULT '0',
  `created_user` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phone
-- ----------------------------
INSERT INTO `phone` VALUES ('1', '0947601397', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 11:18:27', '2018-08-15 04:18:27');
INSERT INTO `phone` VALUES ('2', '0943051175', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 11:16:18', '2018-08-15 11:16:18');
INSERT INTO `phone` VALUES ('3', '0947911326', 'TRATRUOC', '500000', '20000', 'admin', '1', '2018-08-16 12:36:33', '2018-08-16 05:36:33');
INSERT INTO `phone` VALUES ('4', '0942166276', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:16', '2018-08-15 00:48:16');
INSERT INTO `phone` VALUES ('5', '0943734328', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:16', '2018-08-15 00:48:16');
INSERT INTO `phone` VALUES ('6', '0948960328', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:17', '2018-08-15 00:48:17');
INSERT INTO `phone` VALUES ('7', '0943845128', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:17', '2018-08-15 00:48:17');
INSERT INTO `phone` VALUES ('8', '0946754992', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:17', '2018-08-15 00:48:17');
INSERT INTO `phone` VALUES ('9', '0943053392', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:17', '2018-08-15 00:48:17');
INSERT INTO `phone` VALUES ('10', '0945853672', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-15 00:48:17', '2018-08-15 00:48:17');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_forget` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'Trần Chung Kiên', '', 'kienkienutc95@gmail.com', '0964953029', null, '', '$2y$10$B8gSJzs0fOzs0IwqWC/AzuCflEmejiK7KT2.aVXPu9TbaJ4/8YV3e', null, 'j3gvgw5NzqHKRDm765jHaLp9WqnCgmITxBU9vu0XWzEX43tcdxSKyuLfKAQh', '2018-08-15 14:14:40', '2018-08-15 04:26:07');
INSERT INTO `users` VALUES ('3', 'member', 'Trần Chung Kiên', 'http://nap-the.local/source/avatar04.png', 'admin@gmail.com', '0964953028', null, '', '$2y$10$VAPVL25.dlkjsJ86li0ET.6BeGXqjNfWxjdoLFYW9DLASqS6iBTKC', null, null, '2018-08-16 08:42:30', '2018-08-16 08:42:30');
INSERT INTO `users` VALUES ('4', 'kientran', 'Trần Chung Kiên', 'http://nap-the.local/source/avatar.png', 'quangminh.vu@vnnplus.vn', '0964953027', null, '', '$2y$10$V7DvwWup4iku7YakUGkHSO.adXSmY0cM0pmAU8YQF9sAe6K8rdHTq', null, null, '2018-08-16 15:44:32', '2018-08-16 15:44:32');
