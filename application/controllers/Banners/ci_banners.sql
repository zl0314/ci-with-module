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

 Date: 01/11/2018 20:20:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_banners
-- ----------------------------
DROP TABLE IF EXISTS `ci_banners`;
CREATE TABLE `ci_banners`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_pos` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '自定义位置',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `listorder` int(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_pos`(`customer_pos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_banners
-- ----------------------------
INSERT INTO `ci_banners` VALUES (4, 'index-top', '/uploads/banners/2018/09/27/4bd4159830d5662c93fe12e6bb355944.png', '', '2018-09-27 09:49:43', '2018-10-23 19:46:15', 1);

SET FOREIGN_KEY_CHECKS = 1;
