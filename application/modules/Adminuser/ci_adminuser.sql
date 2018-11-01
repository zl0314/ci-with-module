/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50547
 Source Host           : localhost:3306
 Source Schema         : ci_module

 Target Server Type    : MySQL
 Target Server Version : 50547
 File Encoding         : 65001

 Date: 01/11/2018 20:21:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_adminuser
-- ----------------------------
DROP TABLE IF EXISTS `ci_adminuser`;
CREATE TABLE `ci_adminuser`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '状态  1禁用  0正常',
  `is_super` tinyint(1) NOT NULL COMMENT '是否是超管 1是 0不是',
  `addtime` datetime NOT NULL,
  `last_login_time` datetime NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '是否系统用户1是 0不是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_adminuser
-- ----------------------------
INSERT INTO `ci_adminuser` VALUES (1, 'zhanglong', '$2y$10$6CM.tZAdvuowYD/Na1as0eCtFTZrXbnc8RRl8ziWEZ75CHENqhpGy', '超管', 0, 1, '2018-09-17 17:54:07', '2018-11-01 16:42:08', 1);
INSERT INTO `ci_adminuser` VALUES (2, 'ceshi', '$2y$10$xtJkj6t9iKMZEYM8wLBsbuzDCxTYH2oBDznOJbFGsAxVbJAZ8wtGW', '测试1', 0, 0, '2018-10-08 17:32:26', '2018-10-09 09:35:09', NULL);

SET FOREIGN_KEY_CHECKS = 1;
