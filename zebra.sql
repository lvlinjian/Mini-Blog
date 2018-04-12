/*
Navicat MySQL Data Transfer

Source Server         : miniblog
Source Server Version : 50558
Source Host           : 47.94.9.214:3306
Source Database       : zebra

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-04-12 15:39:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `subject` varchar(255) DEFAULT NULL,
  `scores` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `subject` varchar(255) DEFAULT NULL,
  `scores` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_article
-- ----------------------------
DROP TABLE IF EXISTS `zebra_article`;
CREATE TABLE `zebra_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '文章标题',
  `cate_id` int(11) DEFAULT '0' COMMENT '分类id',
  `content` text COMMENT '内容',
  `pubtime` datetime DEFAULT NULL,
  `hits` int(11) DEFAULT '0' COMMENT '阅读量',
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_auth
-- ----------------------------
DROP TABLE IF EXISTS `zebra_auth`;
CREATE TABLE `zebra_auth` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `auth_name` varchar(25) NOT NULL COMMENT '权限名称',
  `pid` tinyint(100) unsigned NOT NULL COMMENT '父id',
  `auth_c` varchar(20) DEFAULT NULL COMMENT '控制器',
  `auth_a` varchar(20) DEFAULT NULL COMMENT '操作方法',
  `is_nav` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否作为菜单显示 1是 0否',
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_name` (`auth_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_cate
-- ----------------------------
DROP TABLE IF EXISTS `zebra_cate`;
CREATE TABLE `zebra_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` char(255) DEFAULT NULL,
  `cate_desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_manager
-- ----------------------------
DROP TABLE IF EXISTS `zebra_manager`;
CREATE TABLE `zebra_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `phone` char(11) DEFAULT NULL,
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `last_login_time` time NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1可用 2禁用',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `role_id` tinyint(3) NOT NULL DEFAULT '4' COMMENT '角色id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_message
-- ----------------------------
DROP TABLE IF EXISTS `zebra_message`;
CREATE TABLE `zebra_message` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `user` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` tinytext NOT NULL,
  `lastdate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for zebra_role
-- ----------------------------
DROP TABLE IF EXISTS `zebra_role`;
CREATE TABLE `zebra_role` (
  `role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `role_auth_ids` varchar(128) NOT NULL COMMENT '添加时间',
  `role_auth_ac` text COMMENT '控制器-操作',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
