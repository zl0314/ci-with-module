/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ci_module

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-12-26 16:38:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ci_adminuser
-- ----------------------------
DROP TABLE IF EXISTS `ci_adminuser`;
CREATE TABLE `ci_adminuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL COMMENT '用户名',
  `password` varchar(60) NOT NULL COMMENT '密码 md5',
  `nickname` varchar(100) NOT NULL COMMENT '真实姓名',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `last_login_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0正常 1禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of ci_adminuser
-- ----------------------------
INSERT INTO `ci_adminuser` VALUES ('1', 'zhanglong', '$2y$10$8jSCX6ZHfJQSNq4oXbv6Fe5Wn0fTHEaA7vMqbLiZ/G7CLTzeNxV/u', '系统管理员', '2015-10-12 08:07:00', '2017-12-26 16:32:30', '0');
