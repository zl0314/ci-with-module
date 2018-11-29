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

 Date: 01/11/2018 20:20:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_privileges
-- ----------------------------
DROP TABLE IF EXISTS `ci_privileges`;
CREATE TABLE `ci_privileges`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `method` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `controller` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `param` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `show_at` tinyint(1) NULL DEFAULT 0 COMMENT '0 顶部  1左侧  2列表上面 3列表项',
  `listorder` int(4) NULL DEFAULT NULL,
  `is_show` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `controller_method`(`controller`, `method`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限节点' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_privileges
-- ----------------------------
INSERT INTO `ci_privileges` VALUES (2, '系统设置', '#re', 'Setting', '', 0, '2018-09-17 18:12:31', 0, 3, NULL);
INSERT INTO `ci_privileges` VALUES (3, '管理员角色', '#ad', 'Adminuser', '', 0, '2018-09-25 11:29:48', 0, 2, NULL);
INSERT INTO `ci_privileges` VALUES (6, '轮播图管理', 'index', 'Banners', '', 2, '2018-10-08 11:40:58', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (7, '添加', 'create', 'Banners', '', 6, '2018-09-17 18:12:55', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (8, '编辑', 'edit', 'Banners', '', 6, '2018-09-17 18:12:55', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (9, '删除', 'delete', 'Banners', '', 6, '2018-09-17 18:12:55', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (10, '批量删除', 'batch_delete', 'Banners', '', 6, '2018-09-17 18:12:55', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (12, '管理员管理', 'index', 'Adminuser', '', 3, '2018-10-08 11:41:14', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (13, '添加', 'create', 'Adminuser', '', 12, '2018-09-25 10:58:37', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (14, '编辑', 'edit', 'Adminuser', '', 12, '2018-09-25 10:58:37', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (15, '删除', 'delete', 'Adminuser', '', 12, '2018-09-25 10:58:37', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (16, '批量删除', 'batch_delete', 'Adminuser', '', 12, '2018-09-25 10:58:37', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (17, '权限管理', 'index', 'Privileges', '', 3, '2018-10-08 11:41:17', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (18, '添加', 'create', 'Privileges', '', 17, '2018-09-25 11:03:35', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (19, '编辑', 'edit', 'Privileges', '', 17, '2018-09-25 11:03:35', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (20, '删除', 'delete', 'Privileges', '', 17, '2018-09-25 11:03:35', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (21, '批量删除', 'batch_delete', 'Privileges', '', 17, '2018-09-25 11:03:35', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (22, '设置项', 'index', 'Setting', '', 2, '2018-09-25 11:04:02', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (23, '添加', 'create', 'Setting', '', 22, '2018-09-25 11:04:02', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (24, '编辑', 'edit', 'Setting', '', 22, '2018-09-25 11:04:02', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (25, '删除', 'delete', 'Setting', '', 22, '2018-09-25 11:04:02', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (26, '批量删除', 'batch_delete', 'Setting', '', 22, '2018-09-25 11:04:02', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (27, '排序', 'listorder', 'Privileges', '', 17, '2018-09-25 11:27:26', 2, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (28, '角色管理', 'index', 'Roles', '', 3, '2018-09-25 11:34:05', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (29, '添加', 'create', 'Roles', '', 28, '2018-09-25 11:34:05', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (30, '编辑', 'edit', 'Roles', '', 28, '2018-09-25 11:34:05', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (31, '删除', 'delete', 'Roles', '', 28, '2018-09-25 11:34:05', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (32, '批量删除', 'batch_delete', 'Roles', '', 28, '2018-09-25 11:34:05', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (33, '排序', 'listorder', 'Banners', '', 6, '2018-09-27 19:16:16', 2, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (34, '内容管理', 'index', '#1540812187', '', 0, '2018-11-01 17:55:09', 1, 1, NULL);
INSERT INTO `ci_privileges` VALUES (35, '新闻管理', 'index', 'News', '', 34, '2018-10-29 19:24:14', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (36, '添加', 'create', 'News', '', 35, '2018-10-29 19:24:14', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (37, '编辑', 'edit', 'News', '', 35, '2018-10-29 19:24:14', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (38, '删除', 'delete', 'News', '', 35, '2018-10-29 19:24:14', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (39, '批量删除', 'batch_delete', 'News', '', 35, '2018-10-29 19:24:14', 2, 0, 1);

SET FOREIGN_KEY_CHECKS = 1;
