/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ci_module

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-08-24 13:53:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ci_settings
-- ----------------------------
DROP TABLE IF EXISTS `ci_settings`;
CREATE TABLE `ci_settings` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `keys` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `value` text CHARACTER SET utf8mb4 NOT NULL,
  `type` tinyint(1) unsigned DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keys` (`keys`(191))
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ci_settings
-- ----------------------------
INSERT INTO `ci_settings` VALUES ('1', 'website', 'Expense Management', '1', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('2', 'logo', 'logo.png', '1', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('3', 'favicon', 'favicon.ico', '3', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('9', 'mail_setting', 'simple_mail', '1', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('10', 'companyname', '&lt;ul class=&quot; list-paddingleft-2&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/index.html&quot;&gt;教程 - 内容提要&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;ul class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: square;&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/static_pages.html&quot;&gt;加载静态内容&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/news_section.html&quot;&gt;读取新闻条目&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/create_news_items.html&quot;&gt;创建新闻条目&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a class=&quot;reference internal&quot; href=&quot;../tutorial/conclusion.html&quot;&gt;结束语&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;&lt;/ul&gt;', '3', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('19', 'aaron', '123123', '1', '2018-08-24 11:45:56');
INSERT INTO `ci_settings` VALUES ('20', 'website', 'Expense Management123111', '1', '2018-08-24 11:45:56');
