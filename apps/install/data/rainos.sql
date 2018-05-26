/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.200
Source Server Version : 50636
Source Host           : 192.168.0.200:3306
Source Database       : rainos

Target Server Type    : MYSQL
Target Server Version : 50636
File Encoding         : 65001

Date: 2017-11-12 14:26:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for rainos_apps
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps`;
CREATE TABLE `rainos_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'test',
  `display_name` varchar(255) DEFAULT NULL,
  `create_user_id` int(11) NOT NULL DEFAULT '1',
  `secret_key` varchar(128) NOT NULL DEFAULT '',
  `crypt` varchar(255) NOT NULL DEFAULT 'not',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `tryout_time` int(11) NOT NULL DEFAULT '0',
  `tryout_points` int(11) DEFAULT '0',
  `use_way` varchar(255) NOT NULL DEFAULT 'time',
  `dec_points` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `version` varchar(255) DEFAULT NULL,
  `down_url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `comment` text,
  `announcement` text,
  `bind_ip` varchar(11) NOT NULL DEFAULT 'off',
  `bind_device_code` varchar(11) NOT NULL DEFAULT 'off',
  `unbind_dec_time` int(11) NOT NULL DEFAULT '0',
  `unbind_dec_points` int(11) NOT NULL DEFAULT '0',
  `unbind_dec_score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unbind_count` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用(app)表';

-- ----------------------------
-- Records of rainos_apps
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_agent
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_agent`;
CREATE TABLE `rainos_apps_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `auth_time` int(11) NOT NULL DEFAULT '0',
  `rebate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代理表';

-- ----------------------------
-- Records of rainos_apps_agent
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_agent_draw
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_agent_draw`;
CREATE TABLE `rainos_apps_agent_draw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `poundage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `actual_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='提现记录';

-- ----------------------------
-- Records of rainos_apps_agent_draw
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_agent_rebate
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_agent_rebate`;
CREATE TABLE `rainos_apps_agent_rebate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `trade_user_id` int(11) NOT NULL DEFAULT '0',
  `trade_record_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `rebate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `centent` text,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代理返利记录';

-- ----------------------------
-- Records of rainos_apps_agent_rebate
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_agent_sort
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_agent_sort`;
CREATE TABLE `rainos_apps_agent_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未命名',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `rebate_ratio` float(3,2) NOT NULL DEFAULT '0.00' COMMENT '折扣',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代理商类型';

-- ----------------------------
-- Records of rainos_apps_agent_sort
-- ----------------------------
INSERT INTO `rainos_apps_agent_sort` VALUES ('1', '未命名', '0', '0', '0.90', '1');

-- ----------------------------
-- Table structure for rainos_apps_agent_user
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_agent_user`;
CREATE TABLE `rainos_apps_agent_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `agent_user_id` int(11) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='代理用户关系表';

-- ----------------------------
-- Records of rainos_apps_agent_user
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_consts
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_consts`;
CREATE TABLE `rainos_apps_consts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'not',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `const` varchar(255) DEFAULT NULL,
  `value` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `comment` text,
  `auth_status` varchar(255) NOT NULL DEFAULT 'off',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用常量数据表';

-- ----------------------------
-- Records of rainos_apps_consts
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_goods
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_goods`;
CREATE TABLE `rainos_apps_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `alias` text,
  `description` text,
  `type` int(11) NOT NULL DEFAULT '1',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `featured_image` varchar(255) DEFAULT NULL,
  `display_image` varchar(255) DEFAULT NULL,
  `content` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `access_num` int(11) DEFAULT '0',
  `sales_num` int(11) NOT NULL DEFAULT '0',
  `sales_volume` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销量 金额',
  `recommend` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用商品表';

-- ----------------------------
-- Records of rainos_apps_goods
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_price
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_price`;
CREATE TABLE `rainos_apps_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT 'day',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(255) NOT NULL DEFAULT 'day' COMMENT 'hour:小时 day:天 week:周 month:月 year:年 unlimited:无限 points :扣点',
  `unit_num` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `comment` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rainos_apps_price
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_user
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_user`;
CREATE TABLE `rainos_apps_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `expire_time` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `connect_time` int(11) NOT NULL DEFAULT '0',
  `connect_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `connect_count` int(11) NOT NULL DEFAULT '0',
  `bind_ip` varchar(255) NOT NULL DEFAULT 'not',
  `bind_device_code` varchar(500) NOT NULL DEFAULT 'not',
  `comment` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `user_data` text,
  `unlimited_status` varchar(255) NOT NULL DEFAULT 'off' COMMENT '永久的时间',
  `tryout_ip` varchar(255) NOT NULL DEFAULT 'not',
  `tryout_device_code` varchar(255) NOT NULL DEFAULT 'not',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户应用关系表';

-- ----------------------------
-- Records of rainos_apps_user
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_user_token
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_user_token`;
CREATE TABLE `rainos_apps_user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL DEFAULT 'not',
  `expire_time` int(11) NOT NULL DEFAULT '0',
  `create_time` varchar(255) DEFAULT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户令牌';

-- ----------------------------
-- Records of rainos_apps_user_token
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_user_var
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_user_var`;
CREATE TABLE `rainos_apps_user_var` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variable_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `value` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户应用变量表';

-- ----------------------------
-- Records of rainos_apps_user_var
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_variables
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_variables`;
CREATE TABLE `rainos_apps_variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未命名',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `variable` varchar(255) NOT NULL DEFAULT 'not',
  `default_value` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应用变量表';

-- ----------------------------
-- Records of rainos_apps_variables
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `rainos_auth_group`;
CREATE TABLE `rainos_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '1',
  `title` char(100) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL DEFAULT 'not',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='权限用户组表';

-- ----------------------------
-- Records of rainos_auth_group
-- ----------------------------
INSERT INTO `rainos_auth_group` VALUES ('1', '0', '超级管理员', '超级管理员拥有网站所有权限', '1', '1', '1,2', '1500273277', '1500480622', 'not');
INSERT INTO `rainos_auth_group` VALUES ('2', '0', '普通用户', '普通用户前台访问', '2', '1', '1,40', '1500459218', '1503993747', '');

-- ----------------------------
-- Table structure for rainos_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `rainos_auth_group_access`;
CREATE TABLE `rainos_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户与组关系表';

-- ----------------------------
-- Records of rainos_auth_group_access
-- ----------------------------
INSERT INTO `rainos_auth_group_access` VALUES ('1', '1', '1504456958', '1504456958');

-- ----------------------------
-- Table structure for rainos_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `rainos_auth_rule`;
CREATE TABLE `rainos_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` char(80) NOT NULL DEFAULT '',
  `alias` varchar(255) DEFAULT NULL,
  `title` char(20) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT 'fa fa-fw fa-sticky-note-o',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `position` varchar(255) NOT NULL DEFAULT 'admin',
  `module` varchar(255) NOT NULL DEFAULT 'admin',
  `class` varchar(255) DEFAULT NULL,
  `show` varchar(255) NOT NULL DEFAULT 'on',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COMMENT='权限数据节点表';

-- ----------------------------
-- Records of rainos_auth_rule
-- ----------------------------
INSERT INTO `rainos_auth_rule` VALUES ('1', '0', '0', 'admin/Index/index', '', '首页', 'fa fa-fw fa-dashboard', '1', '1', '', '0', '0', 'admin', 'admin', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('2', '0', '0', 'admin/System/index', '', '系统', 'fa fa-fw fa-cog', '1', '1', '', '0', '0', 'admin', 'system', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('3', '0', '0', 'admin/User/index', '', '用户', 'fa fa-fw fa-user', '1', '1', '', '0', '0', 'admin', 'user', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('5', '0', '0', 'admin/Page/index', '', '门户', 'fa fa-fw fa-globe', '1', '1', '', '0', '0', 'admin', 'page', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('6', '1', '0', 'admin/Index/index', '', '快捷菜单', 'fa fa-fw fa-th-list', '1', '1', '', '0', '0', 'admin', 'admin', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('7', '6', '0', 'admin/Index/index', '', '管理首页', 'fa fa-fw fa-dashboard', '1', '1', '', '0', '0', 'admin', 'admin', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('8', '2', '0', 'admin/System/index', '', '系统管理', 'fa fa-fw fa-cog', '1', '1', '', '0', '0', 'admin', 'admin', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('9', '2', '0', 'admin/Extend/index', '', '扩展中心', 'fa fa-fw fa-dropbox', '1', '1', '', '0', '0', 'admin', 'admin', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('10', '3', '0', 'admin/User/index', null, '用户管理', 'fa fa-fw fa-user', '1', '1', '', '0', '0', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('11', '3', '0', 'admin/Roler/index', null, '权限控制', 'fa fa-fw fa-group', '1', '1', '', '0', '0', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('18', '5', '0', 'admin/Post/index', null, '文章管理', 'si fa-fw si-pin', '1', '1', '', '0', '0', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('19', '5', '0', 'admin/Page/index', null, '页面管理', 'fa fa-fw fa-paste', '1', '1', '', '0', '0', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('20', '5', '0', 'admin/PageConfig/index', null, '界面主题', 'si fa-fw si-layers', '1', '1', '', '0', '0', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('21', '31', '0', 'admin/Base/upload', null, '文件上传', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('22', '31', '0', 'admin/Base/editupload', null, '编辑器上传', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('23', '8', '0', 'admin/Database/index', null, '数据库备份', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('24', '23', '0', 'admin/Database/back', null, '备份', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('25', '23', '0', 'admin/Database/recovery', null, '还原', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('26', '23', '0', 'admin/Database/optimize', null, '优化表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('27', '23', '0', 'admin/Database/repair', null, '修复表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('28', '23', '0', 'admin/Database/delete', null, '删除备份', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('29', '23', '0', 'admin/Database/datalist', null, '数据列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('30', '23', '0', 'admin/Database/databaklist', null, '备分列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('31', '8', '0', 'admin/Base/index', null, '系统管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('32', '8', '0', 'admin/Menu/index', null, '菜单管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('33', '32', '0', 'admin/Menu/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('34', '32', '0', 'admin/Menu/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('35', '9', '0', 'admin/Module/index', null, '模块管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('36', '35', '0', 'admin/Module/lists', null, '模块列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('37', '35', '0', 'admin/Module/install', null, '安装', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('38', '35', '0', 'admin/Module/unInstall', null, '卸载', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('39', '9', '0', 'admin/Plugin/index', null, '插件管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('40', '39', '0', 'admin/Plugin/lists', null, '插件列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('41', '39', '0', 'admin/Plugin/install', null, '安装', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('42', '39', '0', 'admin/Plugin/unInstall', null, '卸载', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('43', '8', '0', 'admin/System/index', null, '系统设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('44', '43', '0', 'admin/System/inConfig', null, '保存设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503903137', '1503903137', 'admin', 'system', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('45', '11', '0', 'admin/Node/index', null, '节点管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('46', '45', '0', 'admin/Node/lists', null, '节点列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('47', '45', '0', 'admin/Node/imports', null, '自动导入', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('48', '45', '0', 'admin/Node/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('49', '45', '0', 'admin/Node/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('50', '45', '0', 'admin/Node/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('51', '45', '0', 'admin/Node/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('52', '11', '0', 'admin/Role/index', null, '角色管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('53', '52', '0', 'admin/Role/lists', null, '角色列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('54', '52', '0', 'admin/Role/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('55', '52', '0', 'admin/Role/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('56', '52', '0', 'admin/Role/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('57', '52', '0', 'admin/Role/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('58', '52', '0', 'admin/Role/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('59', '52', '0', 'admin/Role/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('60', '52', '0', 'admin/Role/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('61', '52', '0', 'admin/Role/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('62', '52', '0', 'admin/Role/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('63', '52', '0', 'admin/Role/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('64', '10', '0', 'admin/User/lists', null, '用户列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('65', '64', '0', 'admin/User/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('66', '64', '0', 'admin/User/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('67', '64', '0', 'admin/User/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('68', '64', '0', 'admin/User/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('69', '64', '0', 'admin/User/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('70', '64', '0', 'admin/User/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('71', '64', '0', 'admin/User/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('72', '64', '0', 'admin/User/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('73', '64', '0', 'admin/User/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('74', '64', '0', 'admin/User/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905483', '1503905483', 'admin', 'user', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('141', '14', '0', 'admin/Developer/auth', null, '认证管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('142', '14', '0', 'admin/Developer/authLists', null, '开发者列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('140', '130', '0', 'admin/Developer/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('139', '130', '0', 'admin/Developer/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('138', '130', '0', 'admin/Developer/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('137', '130', '0', 'admin/Developer/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('136', '130', '0', 'admin/Developer/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('135', '130', '0', 'admin/Developer/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('134', '130', '0', 'admin/Developer/inEdit', null, '保存编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('133', '130', '0', 'admin/Developer/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('132', '130', '0', 'admin/Developer/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('131', '130', '0', 'admin/Developer/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('128', '119', '0', 'admin/AppVariable/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('129', '119', '0', 'admin/AppVariable/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('127', '119', '0', 'admin/AppVariable/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('130', '14', '0', 'admin/Developer/lists', null, '开发者列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('122', '119', '0', 'admin/AppVariable/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('123', '119', '0', 'admin/AppVariable/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('124', '119', '0', 'admin/AppVariable/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('125', '119', '0', 'admin/AppVariable/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('126', '119', '0', 'admin/AppVariable/lists', null, '常量', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('116', '108', '0', 'admin/AppTimingCardType/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('117', '108', '0', 'admin/AppTimingCardType/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('118', '108', '0', 'admin/AppTimingCardType/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('119', '12', '0', 'admin/AppVariable/add', null, '变量管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('120', '119', '0', 'admin/AppVariable/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('121', '119', '0', 'admin/AppVariable/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('115', '108', '0', 'admin/AppTimingCardType/Lists', null, '卡类列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('114', '108', '0', 'admin/AppTimingCardType/start', null, '卡类启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('113', '108', '0', 'admin/AppTimingCardType/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('110', '108', '0', 'admin/AppTimingCardType/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('111', '108', '0', 'admin/AppTimingCardType/inEdit', null, '保存', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('112', '108', '0', 'admin/AppTimingCardType/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('107', '98', '0', 'admin/AppTimingCard/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('108', '13', '0', 'admin/AppTimingCardType/index', null, '卡类管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('109', '108', '0', 'admin/AppTimingCardType/inAdd', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('103', '98', '0', 'admin/AppTimingCard/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('104', '98', '0', 'admin/AppTimingCard/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('105', '98', '0', 'admin/AppTimingCard/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('106', '98', '0', 'admin/AppTimingCard/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('102', '98', '0', 'admin/AppTimingCard/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('99', '98', '0', 'admin/AppTimingCard/lists', null, '卡列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('101', '98', '0', 'admin/AppTimingCard/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('100', '98', '0', 'admin/AppTimingCard/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('98', '13', '0', 'admin/AppTimingCard/index', null, '充值卡管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('97', '87', '0', 'admin/AppConst/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('96', '87', '0', 'admin/AppConst/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('95', '87', '0', 'admin/AppConst/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('94', '87', '0', 'admin/AppConst/lists', null, '常量列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('92', '87', '0', 'admin/AppConst/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('93', '87', '0', 'admin/AppConst/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('91', '87', '0', 'admin/AppConst/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('90', '87', '0', 'admin/AppConst/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('89', '87', '0', 'admin/AppConst/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('86', '76', '0', 'admin/App/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('167', '5', '0', 'admin/Index/index', null, '管理首页', 'fa fa-fw fa-sticky-note-o', '1', '0', '', '1503906916', '1503906916', 'admin', 'admin', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('168', '19', '0', 'admin/Page/lists', null, '页面列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('169', '168', '0', 'admin/Page/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('170', '168', '0', 'admin/Page/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('171', '168', '0', 'admin/Page/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('172', '168', '0', 'admin/Page/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('173', '168', '0', 'admin/Page/getType', null, '取页面模板', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('174', '168', '0', 'admin/Page/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('175', '168', '0', 'admin/Page/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('176', '168', '0', 'admin/Page/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('177', '168', '0', 'admin/Page/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('178', '168', '0', 'admin/Page/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('179', '168', '0', 'admin/Page/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('180', '20', '0', 'admin/PageConfig/index', null, '界面设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('181', '180', '0', 'admin/PageConfig/inConfig', null, '保存设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('182', '20', '0', 'admin/PageConfig/theme', null, '主题设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('183', '182', '0', 'admin/PageConfig/active', null, '保存主题设置', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('184', '20', '0', 'admin/PageNav/index', null, '导航菜单管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('185', '184', '0', 'admin/PageNav/save', null, '保存菜单排序', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('186', '184', '0', 'admin/PageNav/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('187', '184', '0', 'admin/PageNav/getHtml', null, '取菜单联动', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('188', '184', '0', 'admin/PageNav/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('189', '184', '0', 'admin/PageNav/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('190', '184', '0', 'admin/PageNav/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('191', '184', '0', 'admin/PageNav/delete', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('192', '18', '0', 'admin/Post/lists', null, '例表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('193', '192', '0', 'admin/Post/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('194', '192', '0', 'admin/Post/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('195', '192', '0', 'admin/Post/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('196', '192', '0', 'admin/Post/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('197', '192', '0', 'admin/Post/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('198', '192', '0', 'admin/Post/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('199', '192', '0', 'admin/Post/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('200', '192', '0', 'admin/Post/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('201', '192', '0', 'admin/Post/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('202', '192', '0', 'admin/Post/delList', null, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('203', '192', '0', 'admin/PostSort/index', null, '文章分类管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('204', '18', '0', 'admin/PostSort/lists', null, '例表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('205', '192', '0', 'admin/PostSort/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('206', '192', '0', 'admin/PostSort/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('207', '192', '0', 'admin/PostSort/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('208', '192', '0', 'admin/PostSort/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('209', '192', '0', 'admin/PostSort/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503907171', '1503907171', 'admin', 'page', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('88', '87', '0', 'admin/AppConst/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('87', '12', '0', 'admin/AppConst/add', null, '常量管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('85', '76', '0', 'admin/App/stopList', null, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('84', '76', '0', 'admin/App/startList', null, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('83', '76', '0', 'admin/App/start', null, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('82', '76', '0', 'admin/App/stop', null, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('81', '76', '0', 'admin/App/del', null, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('80', '76', '0', 'admin/App/inEdit', null, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('79', '76', '0', 'admin/App/edit', null, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('78', '76', '0', 'admin/App/inAdd', null, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('77', '76', '0', 'admin/App/add', null, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('76', '12', '0', 'admin/App/lists', null, '应用列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('75', '76', '0', 'admin/App/manage', null, '综合管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('16', '4', '0', 'admin/AppShop/index', null, '商店管理', 'fa fa-fw fa-shopping-cart', '1', '1', '', '0', '0', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('14', '4', '0', 'admin/Developer/index', null, '开发者', 'si fa-fw si-graduation', '1', '1', '', '0', '0', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('15', '4', '0', 'admin/Agent/index', null, '代理商', 'fa fa-fw fa-handshake-o', '1', '1', '', '0', '0', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('4', '0', '0', 'admin/App/index', '', '应用', 'fa fa-fw fa-paper-plane', '1', '1', '', '0', '0', 'admin', 'app', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('13', '4', '0', 'admin/AppTimingCard/index', null, '卡管理', 'si fa-fw si-credit-card', '1', '1', '', '0', '0', 'admin', 'app', null, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('12', '4', '0', 'admin/App/index', null, '应用管理', 'fa fa-fw fa-paper-plane-o', '1', '1', '', '0', '0', 'admin', 'app', null, 'on');

-- ----------------------------
-- Table structure for rainos_configs
-- ----------------------------
DROP TABLE IF EXISTS `rainos_configs`;
CREATE TABLE `rainos_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'not',
  `title` varchar(255) NOT NULL DEFAULT '未设置',
  `group` varchar(255) NOT NULL DEFAULT 'global',
  `type` varchar(255) NOT NULL DEFAULT 'config',
  `value` text,
  `options` text,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `tips` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='网站设置';

-- ----------------------------
-- Records of rainos_configs
-- ----------------------------
INSERT INTO `rainos_configs` VALUES ('1', 'data_backup_path', '数据库备份路径', 'database', 'config', 'databak', '', '1503245646', '');
INSERT INTO `rainos_configs` VALUES ('2', 'data_backup_part_size', '数据库备份卷大小', 'database', 'config', '20961520', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('3', 'data_backup_compress', '数据库备份文件是否启用压缩', 'database', 'config', '1', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('4', 'data_backup_compress_level', '数据库备份文件压缩级别', 'database', 'config', '4', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('5', 'site_title', '网站标题', 'global', 'config', 'Rain OS', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('6', 'site_keyword', '网站关键词', 'global', 'config', 'Rain OS, 新一代,网络应用,管理框架', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('7', 'site_logo', '站点LOGO', 'global', 'config', '', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('8', 'site_description', '网站描述', 'global', 'config', 'Rain OS 全新的UI界面,完美的APP对接应用系统s															', '', '1502262535', '');
INSERT INTO `rainos_configs` VALUES ('9', 'site_switch', '网站开关', 'global', 'config', 'on', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('10', 'site_key', '网站通讯KEY', 'global', 'config', 'RainOS', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('11', 'site_secret_time', '密文有效期', 'global', 'config', '1', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('12', 'upfile_size', '文件上传大小限制', 'global', 'config', '1024', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('13', 'upfile_type', '文件上传类型', 'global', 'config', 'zip,rar,gz', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('14', 'upimg_size', '图片上传大小限制', 'global', 'config', '1024', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('15', 'upimg_type', '图片上传类型', 'global', 'config', 'img,png,jpg,jpge', '', '1500213085', '');
INSERT INTO `rainos_configs` VALUES ('16', 'app_debug', '开发模式', 'global', 'config', '1', '', '1507975084', '');
INSERT INTO `rainos_configs` VALUES ('17', 'app_trace', '页面Trace', 'global', 'config', '0', '', '1508059889', '');
INSERT INTO `rainos_configs` VALUES ('18', 'app_agent_layer', '获得下级返利层级', 'app', 'config', '0', null, '0', null);
INSERT INTO `rainos_configs` VALUES ('19', 'app_agent_layer_rebate_', '获得下级分红率', 'app', 'config', '0.1', null, '0', null);
INSERT INTO `rainos_configs` VALUES ('20', 'magager_websorket_key', 'wesocket密钥', 'global', 'config', 'c78af895fcf41d41520e4', null, '1509690664', null);

-- ----------------------------
-- Table structure for rainos_menu
-- ----------------------------
DROP TABLE IF EXISTS `rainos_menu`;
CREATE TABLE `rainos_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未命名' COMMENT '名称',
  `alias` varchar(255) DEFAULT NULL,
  `module` varchar(255) NOT NULL DEFAULT 'system' COMMENT '类型  系统：systme  模块:module  插件：plugs',
  `position` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '位置，后台：admin  前台：index  用户：user',
  `node` varchar(255) DEFAULT NULL COMMENT '路径  如：admin/Index/index',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级',
  `icon` varchar(255) DEFAULT NULL COMMENT 'fa图标',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `class` varchar(255) DEFAULT '' COMMENT '样式表，选中样式',
  `show` varchar(11) NOT NULL DEFAULT 'on',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2318 DEFAULT CHARSET=utf8 COMMENT='导航菜单总表';

-- ----------------------------
-- Records of rainos_menu
-- ----------------------------
INSERT INTO `rainos_menu` VALUES ('1', '首页', '后台首页', 'admin', 'admin', 'admin/Index/index', '0', '0', 'fa fa-fw fa-dashboard', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('2', '快捷菜单', '快捷菜单', 'admin', 'admin', 'admin/Index/index', '100', '1', 'fa fa-fw fa-th-list', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('3', '系统', '系统管理', 'system', 'admin', 'admin/System/index', '2', '0', 'fa fa-fw fa-cog', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('4', '系统管理', '系统管理', 'system', 'admin', 'admin/System/index', '2', '3', 'fa fa-fw fa-cog', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('5', '系统设置', '设置全局系统功能，和定议一些数据常量', 'systme', 'admin', 'admin/System/index', '200', '4', 'fa fa-fw fa-wrench', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('8', '后台首页', '管理首页', 'admin', 'admin', 'admin/Index/index', '8', '2', 'fa fa-fw fa-dashboard', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('10', '菜单设置', '后台菜单管理设置', 'system', 'admin', 'admin/Menu/index', '201', '4', 'fa fa-fw fa-navicon', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('11', '增加菜单', '增加后台菜单', 'system', 'admin', 'admin/Menu/add', '202', '4', 'fa fa-fw fa-outdent', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('12', '数据库管理', '数据库备份还原管理', 'system', 'admin', 'admin/Database/index', '209', '4', 'fa fa-fw fa-database', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('20', '用户', '用户管理', 'user', 'admin', 'admin/User/index', '3', '0', 'fa fa-fw fa-user', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('40', '门户', '页面管理', 'page', 'admin', 'admin/Post/index', '5', '0', 'fa fa-fw fa-globe', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('50', '扩展中心', '扩展中心', 'system', 'admin', 'admin/Extend/index', '6', '3', 'fa fa-fw fa-dropbox', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('52', '模块管理', '模块管理', 'system', 'admin', 'admin/Module/index', '20', '50', 'fa fa-fw fa-microchip', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('54', '插件管理', '插件管理', 'system', 'admin', 'admin/Plugin/index', '30', '50', 'fa fa-fw fa-plug', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('200', '用户管理', '用户管理', 'user', 'admin', 'admin/User/index', '30', '20', 'fa fa-fw fa-user', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('210', '用户列表', '用户列表', 'user', 'admin', 'admin/User/index', '15', '200', 'fa fa-fw fa-users', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('220', '添加用户', '添加用户', 'user', 'admin', 'admin/User/add', '20', '200', 'fa fa-fw fa-user-plus', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('700', '权限控制', '用户权限管理', 'user', 'admin', 'admin/Node/index', '700', '20', 'fa fa-fw fa-group', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('703', '角色管理', '角色权限管理', 'user', 'admin', 'admin/Role/index', '703', '700', 'si fa-fw si-users', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('705', '节点管理', '管理权限节点', 'user', 'admin', 'admin/Node/index', '705', '700', 'si fa-fw si-share', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('710', '添加节点', '添加权限节点', 'user', 'admin', 'admin/Node/add', '710', '700', 'fa fa-fw fa-code-fork', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('900', '文章管理', '页面文章管理', 'page', 'admin', 'admin/Post/index', '900', '40', 'si fa-fw si-pin', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('910', '文章列表', '管理文章列表', 'page', 'admin', 'admin/Post/index', '910', '900', 'fa fa-fw fa-list-ol', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('920', '撰写文章', '撰写新文章', 'page', 'admin', 'admin/Post/add', '920', '900', 'fa fa-fw fa-edit', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('930', '分类目录', '文章分类管理', 'page', 'admin', 'admin/PostSort/index', '930', '900', 'fa fa-fw fa-window-restore', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1000', '页面管理', '管理独立页面', 'page', 'admin', 'admin/Page/index', '1000', '40', 'fa fa-fw fa-paste', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1010', '所有页面', '管理前台所有独立页面', 'page', 'admin', 'admin/Page/index', '1010', '1000', 'fa fa-fw fa-file-text', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1020', '新建页面', '新建独立页面', 'page', 'admin', 'admin/Page/add', '1020', '1000', 'fa fa-fw fa-file-code-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1021', '编辑页面', '编辑独立页面', 'page', 'admin', 'admin/Page/edit', '1021', '1000', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1100', '界面主题', '主题,界面,菜单,页面项设置', 'page', 'admin', 'admin/PageConfig/index', '1100', '40', 'si fa-fw si-layers', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1110', '主题管理', '界面主题管理', 'page', 'admin', 'admin/PageConfig/theme', '1110', '1100', 'fa fa-fw fa-thumb-tack', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1120', '导航菜单', '导航菜单设置', 'page', 'admin', 'admin/PageNav/index', '1120', '1100', 'fa fa-fw fa-navicon', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1130', '界面设置', '主题界面设置', 'page', 'admin', 'admin/PageConfig/index', '1130', '1100', 'si fa-fw si-home', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('527', '代理提现', '代理商提现', 'app', 'admin', 'admin/AppAgentDraw/draw', '527', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('530', '提现记录', '代理商提现记录', 'app', 'admin', 'admin/AppAgentDraw/index', '530', '500', 'fa fa-fw fa-dollar', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('326', '用户应用', '编辑用户应用', 'app', 'admin', 'admin/AppUser/edit', '320', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('523', '编辑代理类型', '编辑代理类型', 'app', 'admin', 'admin/AppAgentSort/edit', '523', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('516', '添加代理用户', '添加代理用户', 'app', 'admin', 'admin/AppAgentUser/add', '516', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('620', '添加商品', '添加要销售的应用', 'app', 'admin', 'admin/AppGoods/add', '620', '600', 'fa fa-fw fa-cart-plus', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('621', '编辑商品', '编辑销售的应用', 'app', 'admin', 'admin/AppGoods/edit', '621', '600', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('605', '价格设置', '销售设置', 'app', 'admin', 'admin/AppPrice/index', '605', '600', 'fa fa-fw fa-dollar', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('610', '商品列表', '应用商店列表', 'app', 'admin', 'admin/AppGoods/index', '610', '600', 'fa fa-fw fa-list-ol', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('520', '代理分类', '代理商类型分类', 'app', 'admin', 'admin/AppAgentSort/index', '520', '500', 'si fa-fw si-layers', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('515', '代理商用户', '代理商的用户', 'app', 'admin', 'admin/AppAgentUser/index', '515', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('600', '销售管理', '应用商店管理', 'app', 'admin', 'admin/AppGoods/index', '600', '30', 'fa fa-fw fa-shopping-cart', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('540', '返利账单', '用户购买给代理商返利记录', 'app', 'admin', 'admin/AppAgentRebate/index', '540', '500', 'fa fa-fw fa-list-alt', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('510', '代理商列表', '代理商管理列表', 'app', 'admin', 'admin/AppAgent/index', '510', '500', 'fa fa-fw fa-navicon', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('500', '代理商', '代理商管理', 'app', 'admin', 'admin/AppAgent/index', '500', '30', 'fa fa-fw fa-handshake-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('512', '添加代理', '添加已存在的用户为代理', 'app', 'admin', 'admin/AppAgent/add', '512', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('513', '编辑代理', null, 'app', 'admin', 'admin/AppAgent/edit', '513', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('522', '添加代理类型', '添加代理商的类型', 'app', 'admin', 'admin/AppAgentSort/add', '522', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('351', '编辑变量', '编辑应用变量,可在客户端写入与读取用户的变量', 'app', 'admin', 'admin/AppVariable/edit', '351', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('350', '应用变量', '用户应用变量,可在客户端写入与读取用户的变量', 'app', 'admin', 'admin/AppVariable/add', '350', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('331', '常量编辑', '编辑应用常量', 'app', 'admin', 'admin/AppConst/edit', '321', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('325', '用户APP', '已经在使用您的软件的用户', 'app', 'admin', 'admin/AppUser/index', '315', '300', 'si fa-fw si-user-following', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('310', '应用列表', '应用列表', 'app', 'admin', 'admin/App/index', '310', '300', 'si fa-fw si-grid', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('330', '应用常量', '添加编辑应用自定义常量', 'app', 'admin', 'admin/AppConst/add', '320', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('320', '添加应用', '开发者添加应用', 'app', 'admin', 'admin/App/add', '310', '300', 'fa fa-fw fa-google-plus', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('300', '应用管理', '应用验证管理', 'app', 'admin', 'admin/App/index', '300', '30', 'fa fa-fw fa-paper-plane-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('30', '应用', '应用管理', 'app', 'admin', 'admin/App/index', '4', '0', 'fa fa-fw fa-paper-plane', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('327', '用户应用例表', '用户应用例表', 'app', 'admin', 'admin/AppUser/userapp', '320', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('313', '编辑应用', '编辑应用', 'app', 'admin', 'admin/App/edit', '310', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('606', '添加价格', '添加价格', 'app', 'admin', 'admin/AppPrice/add', '606', '600', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('607', '编辑价格', '编辑价格', 'app', 'admin', 'admin/AppPrice/edit', '607', '600', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('15', '支付设置', '支付设置', 'system', 'admin', 'admin/Pay/index', '230', '4', 'fa fa-fw fa-paypal', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1200', '仪表盘', '仪表盘', 'user', 'user', 'index/UserDashboard/index', '1', '0', 'fa fa-fw fa-dashboard', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1210', '个人设置', '用户设置', 'user', 'user', 'index/UserSettings/index', '2', '0', 'si fa-fw si-settings', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1220', '我的应用', '我的应用', 'app', 'user', 'index/UserApp/index', '3', '0', 'si fa-fw si-paper-plane', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1230', '交易记录', '交易记录', 'app', 'user', 'index/UserSales/index', '1230', '0', 'fa fa-fw fa-paypal', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1240', '代理信息', '代理商信息', 'app_agent', 'user', 'index/AgentInfo/index', '1240', '0', 'fa fa-fw fa-user-secret', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('708', '编辑权限', '编辑权限', 'user', 'admin', 'admin/Role/edit', '706', '700', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('707', '添加角色', '添加角色', 'user', 'admin', 'admin/Role/add', '707', '700', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1122', '编辑菜单', '编辑导航菜单菜单', 'page', 'admin', 'admin/PageNav/edit', '1122', '1100', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1123', '添加菜单', '添加导航菜单菜单', 'page', 'admin', 'admin/PageNav/add', '1123', '1100', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('230', '编辑用户', '编辑用户', 'user', 'admin', 'admin/User/edit', '30', '200', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('922', '编辑文章', '编辑文章', 'page', 'admin', 'admin/Post/edit', '922', '900', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('328', '在线用户', '在用的用户', 'app', 'admin', 'admin/AppUser/online', '320', '300', 'fa fa-fw fa-jsfiddle', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('361', '充值卡管理', '充值卡管理', 'app', 'admin', 'admin/AppRechargeCard/index', '361', '300', 'fa fa-fw fa-credit-card', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('362', '卡类管理', '卡类管理', 'app', 'admin', 'admin/AppRechargeCardType/index', '362', '300', 'fa fa-fw fa-credit-card-alt', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('363', '编辑卡类', '编辑卡类', 'app', 'admin', 'admin/AppRechargeCardType/edit', '363', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('364', '添加卡', '添加卡', 'app', 'admin', 'admin/AppRechargeCard/add', '364', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('18', '系统日志', '系统日志', 'system', 'admin', 'admin/Log/index', '232', '4', 'si fa-fw si-note', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('19', '黑名单管理', '黑名单管理', 'system', 'admin', 'admin/BlockList/index', '233', '4', 'si fa-fw si-list', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('192', '添加黑名单', '添加黑名单', 'system', 'admin', 'admin/BlockList/add', '192', '19', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('193', '编辑黑名单', '编辑黑名单', 'system', 'admin', 'admin/BlockList/edit', '193', '19', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('514', '代理商卡管理', '代理商管理设置', 'app', 'admin', 'admin/AppAgentCardInfo/index', '513', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('517', '代理商卡设置', '代理商卡数量设置', 'app', 'admin', 'admin/AppAgentCardInfo/setup', '517', '500', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1250', '代理应用', '代理应用', 'app_agent', 'user', 'index/AgentApp/index', '1250', '0', 'fa fa-fw fa-paper-plane', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('1251', '代理商卡管理', '代理商卡管理', 'app_agent', 'user', 'index/AgentInfo/card', '1251', '0', null, '1', '', 'off', '0', '0');


-- ----------------------------
-- Table structure for rainos_modules
-- ----------------------------
DROP TABLE IF EXISTS `rainos_modules`;
CREATE TABLE `rainos_modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '插件描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text NOT NULL COMMENT '配置信息',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `admin` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理',
  `is_system` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='模块表';

-- ----------------------------
-- Records of rainos_modules
-- ----------------------------
INSERT INTO `rainos_modules` VALUES ('9', 'App', '应用', 'fa fa-paper-plane', '应用验证系统', 'Rain', 'http://www.rain68.com', '', '1.0', 'app.rainos.module', '0', '0', '1504364600', '1504364600', '100', '1');

-- ----------------------------
-- Table structure for rainos_pages
-- ----------------------------
DROP TABLE IF EXISTS `rainos_pages`;
CREATE TABLE `rainos_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '未命名',
  `url_name` varchar(255) DEFAULT NULL,
  `alias` text,
  `type` varchar(255) NOT NULL DEFAULT 'page',
  `description` text,
  `tpl` varchar(255) DEFAULT 'page',
  `content` text,
  `orher_content` text,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT 'admin',
  `featured_image` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站页面';

-- ----------------------------
-- Records of rainos_pages
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_pages_nav
-- ----------------------------
DROP TABLE IF EXISTS `rainos_pages_nav`;
CREATE TABLE `rainos_pages_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'not',
  `alias` text,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `module` varchar(255) NOT NULL DEFAULT 'index',
  `type` varchar(255) NOT NULL DEFAULT 'page',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT 'not',
  `icon` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `show` varchar(255) NOT NULL DEFAULT 'on',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='前台导航菜单';

-- ----------------------------
-- Records of rainos_pages_nav
-- ----------------------------
INSERT INTO `rainos_pages_nav` VALUES ('1', '首页', '首页', '0', '0', 'index', 'index', '0', 'index/Index/index', 'fa fa-fw fa-home', '1', 'on', '1502852218', '1502852218');
INSERT INTO `rainos_pages_nav` VALUES ('2', '应用商店', '应用商店', '0', '0', 'app', 'app', '0', 'index/AppShop/index', 'fa fa-fw fa-paper-plane-o', '1', 'on', '1504538377', '1507476924');

-- ----------------------------
-- Table structure for rainos_pages_theme
-- ----------------------------
DROP TABLE IF EXISTS `rainos_pages_theme`;
CREATE TABLE `rainos_pages_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'defaults',
  `group` varchar(255) NOT NULL DEFAULT 'page',
  `type` varchar(255) NOT NULL DEFAULT 'defaults',
  `value` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='前台模板主题设置';

-- ----------------------------
-- Records of rainos_pages_theme
-- ----------------------------
INSERT INTO `rainos_pages_theme` VALUES ('1', 'theme_path', '主题设置', 'defaults', 'page', 'theme', 'defaults', '0', '1502167187');
INSERT INTO `rainos_pages_theme` VALUES ('2', 'site_title', '网站标题', 'defaults', 'page', 'defaults', 'Rain OS X', '0', '0');
INSERT INTO `rainos_pages_theme` VALUES ('3', 'site_keywords', '网站关键词', 'defaults', 'page', 'defaults', 'Rain OS,新一代网站管理系统', '0', '0');
INSERT INTO `rainos_pages_theme` VALUES ('4', 'site_logo', '网站LOGO', 'defaults', 'page', 'defaults', '/public/uploads/admin/20170819/4a99cf7bde2c63dcaa7d317128ba2238.png', '0', '1503109228');
INSERT INTO `rainos_pages_theme` VALUES ('5', 'site_description', '网站描述', 'defaults', 'page', 'defaults', 'Rain OS 全新的UI界面s', '0', '1502262757');
INSERT INTO `rainos_pages_theme` VALUES ('6', 'widescreen_background', '宽屏背景图', 'defaults', 'page', 'defaults', '/public/static/oneui/img/various/hero1.jpg', '0', '1502854595');
INSERT INTO `rainos_pages_theme` VALUES ('7', 'widescreen_img', '宽屏图片', 'defaults', 'page', 'defaults', '/public/static/index/img/pt1.png', '0', '1502360613');
INSERT INTO `rainos_pages_theme` VALUES ('8', 'widescreen_text', '宽屏文字', 'defaults', 'page', 'defaults', 'APP网络认证功能强大 , 灵活可靠的结构体系 . 数以千计的网络开发者和网络机构的信任 .', '0', '1502782855');
INSERT INTO `rainos_pages_theme` VALUES ('9', 'widescreen_button', '宽屏按钮名称', 'defaults', 'page', 'defaults', '立即注册', '0', '1502360613');
INSERT INTO `rainos_pages_theme` VALUES ('10', 'widescreen_button_link', '宽屏按钮链接', 'defaults', 'page', 'defaults', '/register.html', '0', '1507976590');
INSERT INTO `rainos_pages_theme` VALUES ('11', 'content_1', '内容区(1)', 'defaults', 'page', 'defaults', '	<div class=\"bg-gray-lighter\">\r\n		<section class=\"content content-boxed\">\r\n			<!-- Section Content -->\r\n			<div class=\"row items-push push-20-t push-20 text-center\">\r\n				<div class=\"col-xs-6 col-sm-3\">\r\n					<div class=\"item item-2x item-circle bg-white border push-10 animated bounceIn\" data-toggle=\"appear\" data-offset=\"-100\" data-class=\"animated bounceIn\">\r\n						<i class=\"fa fa-user text-amethyst\"></i>\r\n					</div>\r\n					<div class=\"h1 push-5\" data-toggle=\"countTo\" data-to=\"32600\" data-after=\"+\">32630+</div>\r\n					<div class=\"font-w600 text-uppercase text-muted\">用户</div>\r\n				</div>\r\n				<div class=\"col-xs-6 col-sm-3\">\r\n					<div class=\"item item-2x item-circle bg-white border push-10 animated bounceIn\" data-toggle=\"appear\" data-offset=\"-100\" data-class=\"animated bounceIn\">\r\n						<i class=\"si si-graduation text-flat\"></i>\r\n					</div>\r\n					<div class=\"h1 push-5\" data-toggle=\"countTo\" data-to=\"3500\" data-after=\"+\">1560+</div>\r\n					<div class=\"font-w600 text-uppercase text-muted\">开发者</div>\r\n				</div>\r\n				<div class=\"col-xs-6 col-sm-3\">\r\n					<div class=\"item item-2x item-circle bg-white border push-10 animated bounceIn\" data-toggle=\"appear\" data-offset=\"-100\" data-class=\"animated bounceIn\">\r\n						<i class=\"fa fa-handshake-o text-city\"></i>\r\n					</div>\r\n					<div class=\"h1 push-5\" data-toggle=\"countTo\" data-to=\"4900\" data-after=\"+\">970+</div>\r\n					<div class=\"font-w600 text-uppercase text-muted\">代理商</div>\r\n				</div>\r\n				<div class=\"col-xs-6 col-sm-3\">\r\n					<div class=\"item item-2x item-circle bg-white border push-10 animated bounceIn\" data-toggle=\"appear\" data-offset=\"-100\" data-class=\"animated bounceIn\">\r\n						<i class=\"fa fa-institution text-warning\"></i>\r\n					</div>\r\n					<div class=\"h1 push-5\" data-toggle=\"countTo\" data-to=\"1400\" data-after=\"+\">1310+</div>\r\n					<div class=\"font-w600 text-uppercase text-muted\">商店 & 商城</div>\r\n				</div>\r\n			</div>\r\n			<!-- END Section Content -->\r\n		</section>\r\n	</div>', '0', '1502854958');
INSERT INTO `rainos_pages_theme` VALUES ('12', 'content_2', '内容区(2)', 'defaults', 'page', 'defaults', '<div class=\"bg-white\">\r\n		<section class=\"content content-boxed\">\r\n			<!-- Section Content -->\r\n			<div class=\"row items-push-3x push-50-t nice-copy\">\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push-30\">\r\n						<span class=\"item item-2x item-circle border\">\r\n                                        <i class=\"si si-rocket\"></i>\r\n                                    </span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-uppercase text-center push-10\">强大的socket/http服务</h3>\r\n					<p>集成socket服务协义 , 数万级长连接并发 , 高性能 TCP/HTTP PHP通信框架 , 时时监听客户端在线事件 . 消息推送服务让你极速发送客户端事件 . http协议获取数据连接短 , 负载更底 . 让你在APP权限认证更无忧 . </p>\r\n				</div>\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push-30\">\r\n						<span class=\"item item-2x item-circle border\">{API}</span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-center push-10\">高速API响应</h3>\r\n					<p>应用API接口极简格式, 每条API都是以json格式返回,处理数据罗辑模块化分层 , 内容极简易读 . 关键数据 \"data\" 动态加密 , 可设置有效期限 增加破解难度 , 明文返回消息 , 让你调试过程更简单 . </p>\r\n				</div>\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push\">\r\n						<span class=\"item item-2x item-circle border\">\r\n                                        <i class=\"si si-eye\"></i>\r\n                                    </span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-uppercase text-center push-10\">美观的UI管理</h3>\r\n					<p>采用国外Bootstrap前端框架 开发的顶尖UI界面 , 清爽直观 极 良好的用户体验 . 完全支持PC与移动端响应式访问 . </p>\r\n				</div>\r\n			</div>\r\n			<div class=\"row items-push-3x nice-copy\">\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push\">\r\n						<span class=\"item item-2x item-circle border\">\r\n                                        <i class=\"si si-key\"></i>\r\n                                    </span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-uppercase text-center push-10\">APP认证服务</h3>\r\n					<p>开发者简洁的APP认证管理 , 可同时开放多个APP认证 . 每个APP独立的Secret KEY , 同时支持手机端 , PC程序认证 . 放便的公告极APP数据管理 ,与权限认证数据 , 还有更强大的云端JS编程 .</p>\r\n				</div>\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push-30\">\r\n						<span class=\"item item-2x item-circle border\">\r\n                                    	<i class=\"si si-user\"></i>\r\n                                    </span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-center push-10\">用户APP权限认证</h3>\r\n					<p>通过http协义提交 用户 权限认证 , 对应APP到其时间 , 充值 解绑 的参数据 都非常直观明了. 并且对数据进行动态加密 , 让数据传输更加安全可靠 .</p>\r\n				</div>\r\n				<div class=\"col-sm-4\">\r\n					<div class=\"text-center push\">\r\n						<span class=\"item item-2x item-circle border\">\r\n                                        <i class=\"si si-share\"></i>\r\n                                    </span>\r\n					</div>\r\n					<h3 class=\"h5 font-w600 text-uppercase text-center push-10\">分级代理模式</h3>\r\n					<p>代理分级别层次管理 , 让开发者无需为推广而花费过多时间 , 上下级代理关系让开发者与代理商取得更多利益 . </p>\r\n				</div>\r\n			</div>\r\n			<!-- END Section Content -->\r\n		</section>\r\n	</div>', '0', '1502854958');
INSERT INTO `rainos_pages_theme` VALUES ('13', 'content_3', '内容区(3)', 'defaults', 'page', 'defaults', '<div class=\"bg-image\" style=\"background-image: url(\'/public/static/oneui/img/photos/photo3@2x.jpg\');\">\r\n		<div class=\"bg-primary-dark-op\">\r\n			<section class=\"content content-full content-boxed\">\r\n				<!-- Section Content -->\r\n			<div class=\"push-20-t push-20 text-center\">\r\n				<h3 class=\"h4 push-20 visibility-hidden\" style=\"color:#ffffff;\" data-toggle=\"appear\">Rain OS认证平台将给你带来更高的利润 , 还有数以万计的用户和代理商 .</h3>\r\n				<a class=\"btn btn-rounded btn-noborder btn-lg btn-primary visibility-hidden\" data-toggle=\"appear\" data-class=\"animated bounceIn\" href=\"/register.html\">现在加入</a>\r\n			</div>\r\n				<!-- END Section Content -->\r\n			</section>\r\n		</div>\r\n	</div>', '0', '1506352574');
INSERT INTO `rainos_pages_theme` VALUES ('14', 'content_4', '内容区(4)', 'defaults', 'page', 'defaults', '', '0', '1506352382');
INSERT INTO `rainos_pages_theme` VALUES ('15', 'content_5', '内容区(5)', 'defaults', 'page', 'defaults', '', '0', '1502360613');
INSERT INTO `rainos_pages_theme` VALUES ('16', 'site_record', '备案号', 'defaults', 'page', 'defaults', '', '0', '1502360613');
INSERT INTO `rainos_pages_theme` VALUES ('17', 'widescreen_title', '宽屏标题', 'defaults', 'page', 'defaults', 'Rain OS为您的APP建立高效的认证销售系统 .', '0', '0');

-- ----------------------------
-- Table structure for rainos_plugins
-- ----------------------------
DROP TABLE IF EXISTS `rainos_plugins`;
CREATE TABLE `rainos_plugins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名称',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '插件标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `description` text NOT NULL COMMENT '插件描述',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text NOT NULL COMMENT '配置信息',
  `version` varchar(16) NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `admin` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台管理',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of rainos_plugins
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_posts
-- ----------------------------
DROP TABLE IF EXISTS `rainos_posts`;
CREATE TABLE `rainos_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `alias` text,
  `description` text,
  `content` text,
  `draft` text,
  `sort_id` varchar(255) DEFAULT NULL,
  `tags` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `delete_time` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) NOT NULL DEFAULT 'admin',
  `top` int(11) NOT NULL DEFAULT '0',
  `access_num` int(11) NOT NULL DEFAULT '0',
  `like` int(11) NOT NULL DEFAULT '0',
  `featured_image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章';

-- ----------------------------
-- Records of rainos_posts
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_posts_sort
-- ----------------------------
DROP TABLE IF EXISTS `rainos_posts_sort`;
CREATE TABLE `rainos_posts_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未定议',
  `byname` varchar(255) DEFAULT NULL,
  `alias` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章分类';

-- ----------------------------
-- Records of rainos_posts_sort
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_site_apps
-- ----------------------------
DROP TABLE IF EXISTS `rainos_site_apps`;
CREATE TABLE `rainos_site_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未命名',
  `title` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) DEFAULT NULL,
  `version` varchar(255) NOT NULL DEFAULT '1.0',
  `down_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `update_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unbind_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `init_update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `content` text,
  `copyright` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站授权应用';

-- ----------------------------
-- Records of rainos_site_apps
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_site_apps_authorize
-- ----------------------------
DROP TABLE IF EXISTS `rainos_site_apps_authorize`;
CREATE TABLE `rainos_site_apps_authorize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `site_app_id` int(11) NOT NULL DEFAULT '0',
  `author_type` varchar(255) NOT NULL DEFAULT 'free',
  `domain` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `server_expire_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站授权应用绑定';

-- ----------------------------
-- Records of rainos_site_apps_authorize
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_trade_record
-- ----------------------------
DROP TABLE IF EXISTS `rainos_trade_record`;
CREATE TABLE `rainos_trade_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL COMMENT '定单名称',
  `total_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '付款金额',
  `body` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `price_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(11) NOT NULL DEFAULT 'buy' COMMENT '购买：buy,充值：recharge',
  `trade_status` varchar(255) NOT NULL DEFAULT 'TRADE_ACTION' COMMENT 'TRADE_ACTION交易中 ,TRADE_FINISHED完成，TRADE_SUCCESS成功',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rainos_trade_record
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_users
-- ----------------------------
DROP TABLE IF EXISTS `rainos_users`;
CREATE TABLE `rainos_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `login_time` int(11) NOT NULL DEFAULT '0',
  `login_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `last_login_time` int(11) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `auth_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of rainos_users
-- ----------------------------
INSERT INTO `rainos_users` VALUES ('1', 'admin', 'administrator', '$2y$10$HB7J9spXIyR5G/DFacYixeJfQqiOp332Tmg9KJe0rEtLdQl3hF4oq', '8888888@qq.com', '10000', '88888888888', '999999999', '', '1503991479', '0.0.0.0', '1510466831', '1510466831', '192.168.0.188', '1509496933', '192.168.0.188', '40', '0', '1', '');


-- ----------------------------
-- Table structure for rainos_apps_recharge_card
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_recharge_card`;
CREATE TABLE `rainos_apps_recharge_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) NOT NULL DEFAULT 'not',
  `card_type_id` int(11) NOT NULL DEFAULT '0',
  `app_id` varchar(255) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `sell_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `use_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user_id` varchar(255) NOT NULL DEFAULT '1',
  `client_ip` varchar(255) DEFAULT NULL,
  `agent_user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rainos_apps_recharge_card
-- ----------------------------

-- ----------------------------
-- Table structure for rainos_apps_recharge_card_type
-- ----------------------------
DROP TABLE IF EXISTS `rainos_apps_recharge_card_type`;
CREATE TABLE `rainos_apps_recharge_card_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'not',
  `value` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(255) NOT NULL DEFAULT 'day',
  `comment` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_user_id` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rainos_block_lists`;
CREATE TABLE `rainos_block_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'ip',
  `value` varchar(255) DEFAULT NULL,
  `comment` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rainos_logs`;
CREATE TABLE `rainos_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'not',
  `user_id` varchar(255) DEFAULT NULL,
  `client_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `client_browser` varchar(255) NOT NULL DEFAULT 'not',
  `client_sys` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `other` text,
  `comment` text NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rainos_apps_user_ws`;
CREATE TABLE `rainos_apps_user_ws` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sum` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `rainos_apps_agent_card_info`;
CREATE TABLE `rainos_apps_agent_card_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `card_type_id` int(11) NOT NULL DEFAULT '0',
  `rem_num` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理商卡生成信息配置';