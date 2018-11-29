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

 Date: 01/11/2018 20:21:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_privileges_role
-- ----------------------------
DROP TABLE IF EXISTS `ci_privileges_role`;
CREATE TABLE `ci_privileges_role`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `permission_role_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ci_privileges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ci_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_privileges_role
-- ----------------------------
INSERT INTO `ci_privileges_role` VALUES (2, 24);
INSERT INTO `ci_privileges_role` VALUES (6, 24);
INSERT INTO `ci_privileges_role` VALUES (7, 24);
INSERT INTO `ci_privileges_role` VALUES (22, 24);
INSERT INTO `ci_privileges_role` VALUES (23, 24);
INSERT INTO `ci_privileges_role` VALUES (24, 24);

SET FOREIGN_KEY_CHECKS = 1;
