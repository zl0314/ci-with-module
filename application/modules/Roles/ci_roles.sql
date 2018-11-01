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

 Date: 01/11/2018 20:20:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_roles
-- ----------------------------
DROP TABLE IF EXISTS `ci_roles`;
CREATE TABLE `ci_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_roles
-- ----------------------------
INSERT INTO `ci_roles` VALUES (23, '将军', '将军', '系统超管，最高权限', '2018-08-11 15:26:31', '2018-08-11 15:26:56');
INSERT INTO `ci_roles` VALUES (24, '测试', '测试', '测试', '2018-08-11 15:28:08', '2018-08-12 15:52:51');

SET FOREIGN_KEY_CHECKS = 1;
