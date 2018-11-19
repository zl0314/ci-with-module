/*
 Navicat Premium Data Transfer

 Source Server         : 47.93.29.190
 Source Server Type    : MySQL
 Source Server Version : 50556
 Source Host           : 47.93.29.190:3307
 Source Schema         : cimodule

 Target Server Type    : MySQL
 Target Server Version : 50556
 File Encoding         : 65001

 Date: 19/11/2018 15:50:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_keyword
-- ----------------------------
DROP TABLE IF EXISTS `ci_keyword`;
CREATE TABLE `ci_keyword`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `target_id` int(10) UNSIGNED NOT NULL,
  `source` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `target_id`(`target_id`, `source`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_keyword
-- ----------------------------
INSERT INTO `ci_keyword` VALUES (1, 2, 'News', '2018-11-16 11:39:07', '驾驶证');
INSERT INTO `ci_keyword` VALUES (2, 1, 'News', '2018-11-16 11:50:47', 'st');
INSERT INTO `ci_keyword` VALUES (3, 2, 'Material', '2018-11-19 12:53:03', '风景');
INSERT INTO `ci_keyword` VALUES (4, 3, 'Material', '2018-11-19 14:31:52', '视频');
INSERT INTO `ci_keyword` VALUES (5, 4, 'Material', '2018-11-19 15:02:53', '语音');

SET FOREIGN_KEY_CHECKS = 1;
