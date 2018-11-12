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

 Date: 09/11/2018 16:00:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_tokens
-- ----------------------------
DROP TABLE IF EXISTS `ci_tokens`;
CREATE TABLE `ci_tokens`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `appid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '1 授权Token 2SNS网页TOKEN 3jsapiticket',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `appid`(`appid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_tokens
-- ----------------------------
INSERT INTO `ci_tokens` VALUES (4, '15_kv82rdvkIS8VVnOYsutI-fifQB_6imNirAICa9lYVMqsFavwVMqjvNSnmRyHt6HoCggfe3Ow5YD1Rf4MBBQFyeuKvuEL545dHBkajQ9F13vUGR6qLEVUkNYOYeFlo1Gc8mUIAhz2UXYIjFUaNIHdABAXSR', '2018-11-07 20:16:53', 'wxa19f6b4b8c630d6f', 1);
INSERT INTO `ci_tokens` VALUES (5, 'sM4AOVdWfPE4DxkXGEs8VAZYfjtXK5eQqvCyatS76LC2ZWWBzQHqYE4Ka7H8gzj3K0w9NwRTKfhnlm0G1yoq5Q', '2018-11-07 20:16:53', 'wxa19f6b4b8c630d6f', 3);

SET FOREIGN_KEY_CHECKS = 1;
