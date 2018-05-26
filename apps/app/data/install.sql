INSERT INTO `rainos_menu` VALUES ('30', '应用', '应用管理', 'app', 'admin', 'admin/App/index', '4', '0', 'fa fa-fw fa-paper-plane', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('300', '应用管理', '应用验证管理', 'app', 'admin', 'admin/App/index', '300', '30', 'fa fa-fw fa-paper-plane-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('305', '综合管理', '管理应用,卡,用户', 'app', 'admin', 'admin/App/manage', '305', '300', 'si fa-fw si-wallet', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('310', '应用列表', '应用列表', 'app', 'admin', 'admin/App/index', '310', '300', 'si fa-fw si-grid', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('320', '添加应用', '开发者添加应用', 'app', 'admin', 'admin/App/add', '310', '300', 'fa fa-fw fa-google-plus', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('330', '应用常量', '添加编辑应用自定义常量', 'app', 'admin', 'admin/AppConst/add', '320', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('331', '常量编辑', '编辑应用常量', 'app', 'admin', 'admin/AppConst/edit', '321', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('350', '应用变量', '用户应用变量,可在客户端写入与读取用户的变量', 'app', 'admin', 'admin/AppVariable/add', '350', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('351', '编辑变量', '编辑应用变量,可在客户端写入与读取用户的变量', 'app', 'admin', 'admin/AppVariable/edit', '351', '300', '', '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('400', '开发者', '开发者', 'app', 'admin', 'admin/Developer/index', '430', '30', 'si fa-fw si-graduation', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('410', '开发者列表', '开发者列表', 'app', 'admin', 'admin/Developer/index', '440', '400', 'si fa-fw si-list', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('415', '认证管理', '开发者认证管理', 'app', 'admin', 'admin/Developer/auth', '445', '400', 'fa fa-fw fa-address-book', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('417', '黑名单', '开发者黑名单', 'app', 'admin', 'admin/Developer/blacklist', '447', '400', 'fa fa-fw fa-address-book-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('500', '代理商', ' 代理商管理', 'app', 'admin', 'admin/Agent/index', '500', '30', 'fa fa-fw fa-handshake-o', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('510', '代理商列表', '代理商管理列表', 'app', 'admin', 'admin/Agent/index', '510', '500', 'fa fa-fw fa-navicon', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('520', '代理分类', '代理商类型分类', 'app', 'admin', 'admin/Agent/type', '520', '500', 'si fa-fw si-layers', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('530', '代理认证', '代理商认证', 'app', 'admin', 'admin/Agent/auth', '530', '500', 'fa fa-fw fa-address-book', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('600', '商店管理', '应用商店管理', 'app', 'admin', 'admin/AppShop/index', '600', '30', 'fa fa-fw fa-shopping-cart', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('605', '销售设置', '销售设置', 'app', 'admin', 'admin/AppShop/setup', '605', '600', 'si fa-fw si-settings', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('361', '充值卡管理', '充值卡管理', 'app', 'admin', 'admin/AppRechargeCard/index', '361', '300', 'fa fa-fw fa-credit-card', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('362', '卡类管理', '卡类管理', 'app', 'admin', 'admin/AppRechargeCardType/index', '362', '300', 'fa fa-fw fa-credit-card-alt', '1', '', 'on', '0', '0');
INSERT INTO `rainos_menu` VALUES ('363', '编辑卡类', '编辑卡类', 'app', 'admin', 'admin/AppRechargeCardType/edit', '363', '300', null, '1', '', 'off', '0', '0');
INSERT INTO `rainos_menu` VALUES ('364', '添加卡', '添加卡', 'app', 'admin', 'admin/AppRechargeCard/add', '364', '300', null, '1', '', 'off', '0', '0');


INSERT INTO `rainos_auth_rule` VALUES ('4', '0', '0', 'admin/App/index', '', '应用', 'fa fa-fw fa-paper-plane', '1', '1', '', '0', '0', 'admin', 'app', '', 'on');
INSERT INTO `rainos_auth_rule` VALUES ('12', '4', '0', 'admin/App/index', NULL, '应用管理', 'fa fa-fw fa-paper-plane-o', '1', '1', '', '0', '0', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('13', '4', '0', 'admin/AppTimingCard/index', NULL, '卡管理', 'si fa-fw si-credit-card', '1', '1', '', '0', '0', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('14', '4', '0', 'admin/Developer/index', NULL, '开发者', 'si fa-fw si-graduation', '1', '1', '', '0', '0', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('15', '4', '0', 'admin/Agent/index', NULL, '代理商', 'fa fa-fw fa-handshake-o', '1', '1', '', '0', '0', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('16', '4', '0', 'admin/AppShop/index', NULL, '商店管理', 'fa fa-fw fa-shopping-cart', '1', '1', '', '0', '0', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('75', '76', '0', 'admin/App/manage', NULL, '综合管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('76', '12', '0', 'admin/App/lists', NULL, '应用列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('77', '76', '0', 'admin/App/add', NULL, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('78', '76', '0', 'admin/App/inAdd', NULL, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('79', '76', '0', 'admin/App/edit', NULL, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('80', '76', '0', 'admin/App/inEdit', NULL, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('81', '76', '0', 'admin/App/del', NULL, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('82', '76', '0', 'admin/App/stop', NULL, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('83', '76', '0', 'admin/App/start', NULL, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('84', '76', '0', 'admin/App/startList', NULL, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('85', '76', '0', 'admin/App/stopList', NULL, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('86', '76', '0', 'admin/App/delList', NULL, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('87', '12', '0', 'admin/AppConst/add', NULL, '常量管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('88', '87', '0', 'admin/AppConst/inAdd', NULL, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('89', '87', '0', 'admin/AppConst/edit', NULL, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('90', '87', '0', 'admin/AppConst/inEdit', NULL, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('91', '87', '0', 'admin/AppConst/del', NULL, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('92', '87', '0', 'admin/AppConst/stop', NULL, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('93', '87', '0', 'admin/AppConst/start', NULL, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('94', '87', '0', 'admin/AppConst/lists', NULL, '常量列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('95', '87', '0', 'admin/AppConst/startList', NULL, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('96', '87', '0', 'admin/AppConst/stopList', NULL, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('97', '87', '0', 'admin/AppConst/delList', NULL, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('98', '13', '0', 'admin/AppTimingCard/index', NULL, '充值卡管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('99', '98', '0', 'admin/AppTimingCard/lists', NULL, '卡列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('100', '98', '0', 'admin/AppTimingCard/add', NULL, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('101', '98', '0', 'admin/AppTimingCard/inAdd', NULL, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('102', '98', '0', 'admin/AppTimingCard/del', NULL, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('103', '98', '0', 'admin/AppTimingCard/stop', NULL, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('104', '98', '0', 'admin/AppTimingCard/start', NULL, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('105', '98', '0', 'admin/AppTimingCard/startList', NULL, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('106', '98', '0', 'admin/AppTimingCard/stopList', NULL, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('107', '98', '0', 'admin/AppTimingCard/delList', NULL, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('108', '13', '0', 'admin/AppTimingCardType/index', NULL, '卡类管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('109', '108', '0', 'admin/AppTimingCardType/inAdd', NULL, '添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('110', '108', '0', 'admin/AppTimingCardType/edit', NULL, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('111', '108', '0', 'admin/AppTimingCardType/inEdit', NULL, '保存', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('112', '108', '0', 'admin/AppTimingCardType/del', NULL, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('113', '108', '0', 'admin/AppTimingCardType/stop', NULL, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('114', '108', '0', 'admin/AppTimingCardType/start', NULL, '卡类启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('115', '108', '0', 'admin/AppTimingCardType/Lists', NULL, '卡类列表', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('116', '108', '0', 'admin/AppTimingCardType/startList', NULL, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('117', '108', '0', 'admin/AppTimingCardType/stopList', NULL, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('118', '108', '0', 'admin/AppTimingCardType/delList', NULL, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('119', '12', '0', 'admin/AppVariable/add', NULL, '变量管理', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('120', '119', '0', 'admin/AppVariable/inAdd', NULL, '确认添加', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('121', '119', '0', 'admin/AppVariable/edit', NULL, '编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('122', '119', '0', 'admin/AppVariable/inEdit', NULL, '确认编辑', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('123', '119', '0', 'admin/AppVariable/del', NULL, '删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('124', '119', '0', 'admin/AppVariable/stop', NULL, '停用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('125', '119', '0', 'admin/AppVariable/start', NULL, '启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('126', '119', '0', 'admin/AppVariable/lists', NULL, '常量', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('127', '119', '0', 'admin/AppVariable/startList', NULL, '批量启用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('128', '119', '0', 'admin/AppVariable/stopList', NULL, '批量禁用', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');
INSERT INTO `rainos_auth_rule` VALUES ('129', '119', '0', 'admin/AppVariable/delList', NULL, '批量删除', 'fa fa-fw fa-sticky-note-o', '1', '1', '', '1503905895', '1503905895', 'admin', 'app', NULL, 'on');


DROP TABLE IF EXISTS `rainos_app_goods`;
CREATE TABLE `rainos_app_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(388) DEFAULT NULL,
  `title` text,
  `type` int(11) NOT NULL DEFAULT '1',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `featured_image` varchar(255) DEFAULT NULL,
  `display_image` varchar(255) DEFAULT NULL,
  `content` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `show` int(1) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='应用商品表';


INSERT INTO `rainos_app_goods` VALUES (1,'Rain CMS','RAINCMS网络验证系统',1,1,'','','',1,0,1489493018,1489493018);


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
  `update_time` int(11) NOT NULL DEFAULT '0',
  `version` varchar(255) DEFAULT NULL,
  `down_url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `comment` text,
  `announcement` text,
  `bind_ip` varchar(11) NOT NULL DEFAULT 'off',
  `bind_device_code` varchar(11) NOT NULL DEFAULT 'off',
  `unbind_dec_time` int(11) NOT NULL DEFAULT '0',
  `unbind_dec_score` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unbind_count` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='应用(app)表';


INSERT INTO `rainos_apps` VALUES (1,'raincms','RAIN网站管理系统',0,'wSnPVbEqUlquzo7QBpgqkYS92WCtFV3OpCNDLQI6l7baA54RtLcXVq76n8iEcPbc','authcode',1489493018,10,1503456430,'V2.2.2','http://www.baidu.coms','/public/uploads/admin/20170823/3486ef3738f63b7793b1eb4b72f162c2.png','12','2','off','off',5,10.00,0,1),(28,'Rain OS','',1,'5cEwF82nqclNJXbtH8SHYb9EYpYsYsHWjUuO4YTWjr2wHG01lK5OdHute5VA1xq4','not',1501753771,0,1501753900,'1.0.0','','','','','on','off',0,0.00,0,2);


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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='应用常量数据表';


INSERT INTO `rainos_apps_consts` VALUES (2,'bbbbbss',1,'cccccccccc','ddddddddddddddd',1497517942,1501401512,1,'','off'),(3,'bbbbbaa',1,'ccccccccccccc','ddddddddddddddd',1497517966,1497517966,1,'','on'),(6,'99995646',2,'465645665465','65465465',1497520264,1497697403,1,'','on'),(7,'9999564654',2,'46564566546554','65465465',1497520288,1497697405,1,'','on'),(8,'999549564654',2,'46564566jkhj546554','65465465',1497520323,1497520323,1,'','on'),(9,'9995hjgjh49564654',2,'4656kjkl4566jkhj546554','65465465',1497520333,1497520333,1,'','on'),(10,'9995hjgjh4956jhj4654',2,'4656kjkl45jkhjk66jkhj546554','6546kjk5465',1497520347,1497520347,1,'','on'),(11,'9995hjg456jh4956jhj4654',2,'4656kjkl45jhjk66jkhj546554','6546kjk5465',1497520356,1497520356,1,'','on'),(12,'dsadas',2,'fdsafdsa','fdsafdsa',1497520485,1497520485,1,'','on'),(13,'dsadasaaaaa',2,'fdsafdsafdsafdsafdsa','fdsafdsa',1497520494,1497520494,1,'','on'),(14,'aaaaa',3,'bbbb','bbbbb',1498124694,1498124705,1,'','on');


DROP TABLE IF EXISTS `rainos_apps_developer`;
CREATE TABLE `rainos_apps_developer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `developer_key` varchar(255) NOT NULL DEFAULT 'not',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='应用代理商表';


INSERT INTO `rainos_apps_developer` VALUES (1,1,'raincms',0,0,1);


DROP TABLE IF EXISTS `rainos_apps_timing_card`;
CREATE TABLE `rainos_apps_timing_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card` varchar(255) DEFAULT NULL,
  `app_id` int(11) NOT NULL DEFAULT '0',
  `create_user_id` int(11) NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `use_id` int(11) NOT NULL DEFAULT '0',
  `use_time` int(11) NOT NULL DEFAULT '0',
  `buy_user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `selling_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0停用  1启用 2已用',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='充值卡表';


INSERT INTO `rainos_apps_timing_card` VALUES (4,'D551596E578EB5FE29415265DC6508B7',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(5,'3BF4807AA65BBE930ED707A349840FDA',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(6,'CECF9E548AFA06A98EBD8EADFC3D6353',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(7,'EC6B0A345CE25D5DD87ACCE89B11C3BD',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(8,'5B31729E586F94EDF57ABB19E429E4A5',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(9,'4F59DDACBC891805A84BC506B8DE5FB6',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(10,'4729D9571883BEDDCA377120224A540B',1,1,2,0,0,0,1500709286,1500709286,0,1,''),(11,'A53BE0165FAFFB42FC5683E47C31DB41',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(12,'073BE2E535F0D24884CA312A6F08E294',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(13,'ABCF536A0423025478AC3BE3D2A8F040',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(14,'F6390CD65A8A9BB9836271BE35CEC5AA',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(15,'1225050D0A00978E70D3E022F2F999CB',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(16,'0A6D5727DA5B9FE2A62442AA030F3C0E',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(17,'50B5DC2E911D11DA7C7EC9123004A130',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(18,'2C5F84CEC3F5F290BA4C4B2D94935458',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(19,'C5A482B416C139ED8903FB6D5ECFDF19',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(20,'CD9ADA901B85F6C4FF5F08BDC8E256CC',1,1,2,0,0,0,1501398695,1501398695,0,1,''),(21,'2912D28E45AE1DA1B57BAEA181C47937',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(22,'7DBDA20CF93B8CE803FDF20F1012B1F4',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(23,'94A6B896CB78E6595B2A4C0646E57C57',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(24,'47CD9C2FDB82F7A69BF32D6EE940C97B',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(25,'18E71C8B315D429C6B02D2DF18253E60',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(26,'33EDC566F407E78FD6865A2A2B903BD3',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(27,'52FBF2FC12821108CE1B3793A4C7D7D0',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(28,'03CE5EC50740DA8D610FD4EE419C0869',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(29,'9108BA8CB58CF435369D7836AAEDDC02',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(30,'6D398FFEF7894134F7AACCE35AA52D4F',1,1,2,0,0,0,1501398711,1501398711,0,1,''),(31,'D60F82F756A2320449DDF02B18FCCC4F',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(32,'8BE0541B0C4F0DDFCB0FDD46102D245F',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(33,'198FC436DE4318C55EEA6D0CB2C8214C',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(34,'E60EF615D538E80EF974794CA153745C',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(35,'16495268AA0A05ACC8D303F16EE2415B',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(36,'ADFBAC05D5861155ACA83A51C239FE1E',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(37,'08497364D1C997D808A5A3DC22B61785',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(38,'7AEA8DA67F95C41A9762548EEA8D066D',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(39,'27786E12359918A2BEA3D4AE6DF652EA',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(40,'75267752D2B9F3C62F20967001343A11',1,1,3,0,0,0,1501398738,1501398738,0,1,''),(41,'3909D3E62399265F0B83754EBC64C02A',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(42,'777712F87DD96B7D1B93FA7128AFCFBD',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(43,'7B2DDC9F4DBB155F7846615712476887',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(44,'57E7AC830BA1F02AA5588CC53DA0AF9C',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(45,'32E641EB69949E2FC4FF3AADB64B364B',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(46,'9194C98C43DC79A42C11325F34E2D332',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(47,'19C4B66468165EA12E2DA902B6068E15',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(48,'9B4158A85D5C49AA5189041FDDCDA4F9',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(49,'EDFED57BF1A7C7D77365C982A53397DE',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(50,'C9270B2814AA45B260F8800BF4746315',1,1,2,0,0,0,1501399043,1501399042,0,1,''),(51,'840C6158ADF48CCB5126A8C123462870',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(52,'5B71076A5BBA67ED561CF7CD6D8F13FF',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(53,'1241AFAE535E4145ECA65F82B0F60596',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(54,'916479B1695BA95E966F3A8BF87136F9',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(55,'FCE5726E34CE600AD55EFC42160E2C98',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(56,'0AB74A981F812EB6EE949547F55BBC3A',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(57,'8E400FC5611A1E23DFC2CD3357B43693',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(58,'AAAAE3B536E259BD5023E4626A5F0CE9',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(59,'79A4A624390DC01F6A544F359671C14B',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(60,'B9D214711D529E34854953D9473D32E9',1,1,2,0,0,0,1501755189,1501755189,0,1,''),(61,'2B790CEB81FC2EC3ECB1F8E6E7CA38F7',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(62,'E831D6E75B87CF408A9439E11581EE2F',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(63,'FE33F87B7CFB62874260618BB1F7DAFF',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(64,'4153110680C11B3F7C4D5D025AF40BF0',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(65,'A66D864A6FCE697BE20C6170718E09BE',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(66,'184D486865C3A6ACAF88B854F4319D60',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(67,'C22748698A3EDC71EEE0B5F055B703D0',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(68,'7CCF634E71D14E7133F272413EC56FA4',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(69,'28624584801ABFC394F1C9A29CC24585',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(70,'E6703CC23E2ECAA70B2A5F70CC65C37B',1,1,2,0,0,0,1501755263,1501755262,0,1,''),(71,'5450FD6FE2CAEE678B45FCA7082130C9',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(72,'46D5ED17CA0F075CFEC7AADE391430A1',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(73,'8568BED6A1F9691AD70B4023B59E128F',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(74,'6383B8E7077379A6603D32C76E9BDEDC',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(75,'9C8B61467F7017FA463AE75F87529FB1',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(76,'E3763F169E1E809090EDA0C7F5F471B0',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(77,'35EED2163D65FE7226E3996F35E39310',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(78,'7F6789ACDCFD03D13895F0F9CBD0AFD4',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(79,'016C53A48861F6634A2FC664F863C32D',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(80,'1CE661B5A447088720BE74E0FB9A6D46',1,1,2,0,0,0,1501755386,1501755386,0,1,''),(81,'44EAEE5832B0552CCF8B8CE5C57AF4AC',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(82,'C1667255153062DEF60E118E714D98EA',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(83,'C1E6B94E603DC0551228DB536F69784E',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(84,'D04025C770A2DC0C271421B92A33983A',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(85,'86A36C9D108E00CA9C35D189500C5219',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(86,'212E129EF89C63F8472A92DF640DF577',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(87,'1D7D18C59671ED1E7F331691227BC9A2',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(88,'1071B3DCF54172D3C5A4AB6D667CB39D',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(89,'7711560EAFEFE32CA31F674280BA3187',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(90,'0F110305139757B8FDE5DBE513951372',1,1,2,0,0,0,1501755400,1501755400,0,1,''),(91,'FDAF97E23C48125BD88906FBBB1F3AAB',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(92,'B67A555AFC761F6BDF51B786054FA695',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(93,'3AC813603D0532872C06C35366F7FD9E',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(94,'097F21B46CCEBC7DF07065FACCBD97F4',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(95,'C88FE72C429D64403FD679A2F115A81C',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(96,'6F7886C89B1AEA8E1A581CC6F020626C',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(97,'6CE79B93C0DEAA1AB711D1535E3BCF47',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(98,'24FB495AA0521791610C841DE83198DF',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(99,'ACA2C416387F5D772301715349BEDAC5',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(100,'E68643B9A8A3C29D2D178A7E40C0EA45',1,1,2,0,0,0,1501755493,1501755493,0,1,''),(101,'FADBB9432CF8AF2F658F8AC2EB400377',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(102,'C15D9473224B069D27337D91106B35D6',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(103,'CAA0E84CB68F98EC5555077CCC4CBD94',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(104,'F5B2AD9B74785AE2234BA124443426FB',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(105,'46F0BCE069258A142DC282A4573997DF',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(106,'0CC34CD2466CF5A2E72996ED66E677E5',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(107,'D1AFB4C3F55493843258B44370728DEC',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(108,'6B9CD53B91A433701D599685BD807E76',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(109,'95ECABED9F807FCB02028452C68C0EE8',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(110,'F26920FE3B81C59967A678EB42A47A2C',1,1,2,0,0,0,1501755512,1501755511,0,1,''),(111,'5BAED1EDD11E0CFB6817B6A04D9D1184',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(112,'82D09678C9A85F895CB4BFDC0B07195B',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(113,'EF4E3497B2C2E1358C30FA9EC8B042C5',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(114,'BEC001AAECE7D6874E8F6670DFD56942',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(115,'71278CABEE69FFF68413FCC42C61CB72',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(116,'7C920CA34DF4EB3CD1FE0D3C6887B77E',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(117,'FF017FA4F976FCCD9BC6FBF4D8C48754',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(118,'C049B99139108869BE34706BC50D4E8C',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(119,'7414C081C7085243AA86BC3E2606DDBE',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(120,'CD1930D220637F945EDD1D6C6C2279C7',1,1,2,0,0,0,1501756873,1501756873,0,1,''),(121,'F603A60C6760E1533BC8813D43E99C90',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(122,'68AB806B89178A2A11D81685EB68D085',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(123,'006480489898FE5F8366A8372095D24D',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(124,'41900694A2C2217BB4EB250310675231',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(125,'67ED89D30D8C6921E3911CEAEB66E934',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(126,'0DAE4CD7ED0A9927A71622D1D66CDC0F',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(127,'473245E714BCC965CAF94BB99FC05BF1',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(128,'939BC714C37E354EE19B64C73386D231',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(129,'D1D529F5AF10D8C2215E5458AE266AB1',1,1,2,0,0,0,1502523593,1502523593,0,1,''),(130,'F8326A827A3815EE3981B04202F32E7F',1,1,2,0,0,0,1502523593,1502523593,0,1,'');


DROP TABLE IF EXISTS `rainos_apps_timing_card_type`;
CREATE TABLE `rainos_apps_timing_card_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '未命名',
  `create_user_id` int(11) NOT NULL DEFAULT '0',
  `unit` varchar(255) NOT NULL DEFAULT 'sec' COMMENT 'min分 hour小时 day天 week星期 month月 year年 unlimited不限制',
  `time_value` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='充值卡类表';


INSERT INTO `rainos_apps_timing_card_type` VALUES (2,'永久卡',1,'unlimited',0,1498139359,1501477978,1,'充值无限期'),(3,'年卡',1,'year',1,1498139703,1498385869,1,'一年'),(4,'天卡',1,'day',1,1498385862,1498386507,1,''),(5,'周卡',1,'week',1,1498385905,1498385905,1,''),(6,'季卡',1,'month',3,1498385920,1498385920,1,''),(7,'半小时卡',1,'min',30,1498385965,1498385965,1,'半小时卡');


DROP TABLE IF EXISTS `rainos_apps_user`;
CREATE TABLE `rainos_apps_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `expire_time` int(11) NOT NULL DEFAULT '0',
  `connect_time` int(11) NOT NULL DEFAULT '0',
  `connect_ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `connect_count` int(11) NOT NULL DEFAULT '0',
  `bind_ip` varchar(255) NOT NULL DEFAULT 'not',
  `bind_device_code` varchar(500) NOT NULL DEFAULT 'not',
  `comment` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `user_data` text,
  `unlimited_status` varchar(255) NOT NULL DEFAULT 'off',
  `tryout_ip` varchar(255) NOT NULL DEFAULT 'not',
  `tryout_device_code` varchar(255) NOT NULL DEFAULT 'not',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户应用关系表';



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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户令牌';


INSERT INTO `rainos_apps_user_token` VALUES (1,1,1,'aaf450b22653b9443634058e09469bf5',1499073558,'1498994887',1499066357);


DROP TABLE IF EXISTS `rainos_apps_user_var`;
CREATE TABLE `rainos_apps_user_var` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variable_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `value` text,
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户应用变量表';


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='应用变量表';



INSERT INTO `rainos_apps_variables` VALUES (1,'aaa',1,'bbb','ccc',1501818053,1501818403,1,'');

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