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

 Date: 09/11/2018 17:16:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `ci_admin_user_role`;
CREATE TABLE `ci_admin_user_role`  (
  `admin_user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`admin_user_id`, `role_id`) USING BTREE,
  INDEX `admin_user_role_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `admin_user_role_admin_user_id_foreign_s` FOREIGN KEY (`admin_user_id`) REFERENCES `ci_adminuser` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `admin_user_role_role_id_foreign_s` FOREIGN KEY (`role_id`) REFERENCES `ci_roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_admin_user_role
-- ----------------------------
INSERT INTO `ci_admin_user_role` VALUES (2, 24);

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
INSERT INTO `ci_adminuser` VALUES (1, 'zhanglong', '$2y$10$6CM.tZAdvuowYD/Na1as0eCtFTZrXbnc8RRl8ziWEZ75CHENqhpGy', '超管', 0, 1, '2018-09-17 17:54:07', '2018-11-09 15:58:58', 1);
INSERT INTO `ci_adminuser` VALUES (2, 'ceshi', '$2y$10$xtJkj6t9iKMZEYM8wLBsbuzDCxTYH2oBDznOJbFGsAxVbJAZ8wtGW', '测试1', 0, 0, '2018-10-08 17:32:26', '2018-10-09 09:35:09', NULL);

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

-- ----------------------------
-- Table structure for ci_news
-- ----------------------------
DROP TABLE IF EXISTS `ci_news`;
CREATE TABLE `ci_news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keyword` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_news
-- ----------------------------
INSERT INTO `ci_news` VALUES (1, 'test', 'st', 'tes', '&lt;p&gt;ts&lt;/p&gt;', '', '2018-11-01 20:13:14', '2018-11-01 20:14:20');

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
INSERT INTO `ci_privileges` VALUES (35, '新闻管理', 'index', 'News', '', 34, '2018-11-07 20:29:40', 1, NULL, NULL);
INSERT INTO `ci_privileges` VALUES (36, '添加', 'create', 'News', '', 35, '2018-10-29 19:24:14', 2, 0, 1);
INSERT INTO `ci_privileges` VALUES (37, '编辑', 'edit', 'News', '', 35, '2018-10-29 19:24:14', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (38, '删除', 'delete', 'News', '', 35, '2018-10-29 19:24:14', 3, 0, 1);
INSERT INTO `ci_privileges` VALUES (39, '批量删除', 'batch_delete', 'News', '', 35, '2018-10-29 19:24:14', 2, 0, 1);

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

-- ----------------------------
-- Table structure for ci_settings
-- ----------------------------
DROP TABLE IF EXISTS `ci_settings`;
CREATE TABLE `ci_settings`  (
  `id` int(122) UNSIGNED NOT NULL AUTO_INCREMENT,
  `keys` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `keys`(`keys`(191)) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ci_settings
-- ----------------------------
INSERT INTO `ci_settings` VALUES (1, 'website', 'Expense Management', 1, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (2, 'logo', 'logo.png', 1, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (3, 'favicon', 'favicon.ico', 3, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (9, 'mail_setting', 'simple_mail', 1, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (10, 'companyname', '&lt;ul class=&quot; list-paddingleft-2&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/index.html&quot;&gt;教程 - 内容提要&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;ul class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: square;&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/static_pages.html&quot;&gt;加载静态内容&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/news_section.html&quot;&gt;读取新闻条目&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/create_news_items.html&quot;&gt;创建新闻条目&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/conclusion.html&quot;&gt;结束语&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/ul&gt;', 3, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (19, 'aaron', '123123', 1, '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES (20, 'website', 'Expense Management123111dcdd1', 1, '2018-08-24 11:45:56');

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
