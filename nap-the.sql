/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : nap-the

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-08-14 15:36:00
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pay_card
-- ----------------------------
INSERT INTO `pay_card` VALUES ('1', '12142352346', '35435346464636', '10000', '10000', '0964953029', '1', '2018-08-14 03:47:42', '2018-08-14 03:47:42');
INSERT INTO `pay_card` VALUES ('2', '12142352346', '35435346464636', '10000', '10000', '0964953029', '1', '2018-08-14 03:47:44', '2018-08-14 03:47:44');
INSERT INTO `pay_card` VALUES ('3', '12142352346', '35435346464636', '10000', '10000', '0964953029', '1', '2018-08-14 03:47:49', '2018-08-14 03:47:49');
INSERT INTO `pay_card` VALUES ('4', '12142352346', '35435346464636', '10000', '10000', '0964953029', '1', '2018-08-14 03:47:51', '2018-08-14 03:47:51');
INSERT INTO `pay_card` VALUES ('5', '12142352346', '35435346464636', '50000', '10000', '0964953029', '0', '2018-08-14 03:48:01', '2018-08-14 03:48:01');
INSERT INTO `pay_card` VALUES ('6', '12142352346', '35435346464636', '50000', '10000', '0964953028', '0', '2018-08-14 03:48:10', '2018-08-14 03:48:10');
INSERT INTO `pay_card` VALUES ('7', '12142352346', '35435346464636', '50000', '10000', '0964953028', '0', '2018-08-14 05:50:39', '2018-08-14 05:50:39');
INSERT INTO `pay_card` VALUES ('8', '12142352346', '35435346464636', '10000', '10000', '0964953029', '1', '2018-08-14 14:02:50', '2018-08-14 14:02:50');
INSERT INTO `pay_card` VALUES ('9', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:02:52', '2018-08-14 14:02:52');
INSERT INTO `pay_card` VALUES ('10', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:02:56', '2018-08-14 14:02:56');
INSERT INTO `pay_card` VALUES ('11', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:02:58', '2018-08-14 14:02:58');
INSERT INTO `pay_card` VALUES ('12', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:03:03', '2018-08-14 14:03:03');
INSERT INTO `pay_card` VALUES ('13', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:03:06', '2018-08-14 14:03:06');
INSERT INTO `pay_card` VALUES ('14', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 14:03:10', '2018-08-14 14:03:10');
INSERT INTO `pay_card` VALUES ('15', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:23', '2018-08-14 07:03:23');
INSERT INTO `pay_card` VALUES ('16', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:26', '2018-08-14 07:03:26');
INSERT INTO `pay_card` VALUES ('17', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:32', '2018-08-14 07:03:32');
INSERT INTO `pay_card` VALUES ('18', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:36', '2018-08-14 07:03:36');
INSERT INTO `pay_card` VALUES ('19', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:37', '2018-08-14 07:03:37');
INSERT INTO `pay_card` VALUES ('20', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:52', '2018-08-14 07:03:52');
INSERT INTO `pay_card` VALUES ('21', '12142352346', '35435346464636', '10000', '10000', '0964953028', '1', '2018-08-14 07:03:54', '2018-08-14 07:03:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phone
-- ----------------------------
INSERT INTO `phone` VALUES ('1', '0964953029', 'TRATRUOC', '100000', '100000', 'admin', '2', '2018-08-14 14:02:08', '2018-08-14 07:02:08');
INSERT INTO `phone` VALUES ('2', '0964953028', 'TRASAU', '500000', '230000', 'admin', '1', '2018-08-14 14:03:54', '2018-08-14 07:03:54');
INSERT INTO `phone` VALUES ('5', '0964953027', 'TRATRUOC', '400000', '0', 'admin', '0', '2018-08-14 08:32:38', '2018-08-14 08:32:38');
INSERT INTO `phone` VALUES ('6', '0962354356', 'TRATRUOC', '300000', '0', 'admin', '0', '2018-08-14 08:32:39', '2018-08-14 08:32:39');
INSERT INTO `phone` VALUES ('7', '01639653755', 'TRATRUOC', '200000', '0', 'admin', '0', '2018-08-14 08:32:39', '2018-08-14 08:32:39');
INSERT INTO `phone` VALUES ('9', '0964983455', 'TRATRUOC', '600000', '0', 'admin', '0', '2018-08-14 08:34:23', '2018-08-14 08:34:23');
INSERT INTO `phone` VALUES ('10', '0964983454', 'TRATRUOC', '500000', '0', 'admin', '0', '2018-08-14 08:34:23', '2018-08-14 08:34:23');
INSERT INTO `phone` VALUES ('11', '0964983453', 'TRATRUOC', '400000', '0', 'admin', '0', '2018-08-14 08:34:23', '2018-08-14 08:34:23');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '', '', 'kienkienutc95@gmail.com', '0964953029', null, '', '$2y$10$B8gSJzs0fOzs0IwqWC/AzuCflEmejiK7KT2.aVXPu9TbaJ4/8YV3e', null, 'GNL2TJSGuOPR0njwp1G652IJjY0YaOFsxTFG0i6EWr8HmIl8YdvAoSMG94Ya', null, '2018-08-13 02:38:46');
