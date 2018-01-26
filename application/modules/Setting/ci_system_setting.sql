/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ci_module

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-01-26 14:05:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ci_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `ci_system_setting`;
CREATE TABLE `ci_system_setting` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `setting` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统设置';

-- ----------------------------
-- Records of ci_system_setting
-- ----------------------------
INSERT INTO `ci_system_setting` VALUES ('1', '{\"id\":\"2\",\"site_title\":\"\\u7ad9\\u70b9\\u6807\\u9898\",\"site_keyword\":\"\\u5173\\u952e\\u5b57\",\"site_description\":\"\\u7ad9\\u70b9\\u63cf\\u8ff0\"}');
