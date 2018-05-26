<?php
// +----------------------------------------------------------------------
// | Rain OS X [ RainOS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 RainSoft [ http://www.rain68.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://rain68.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\install\controller;

use think\Controller;


define('INSTALL_APP_PATH', realpath('./') . '/');

/**
 * 安装控制器
 * @package app\install\controller
 */
class Update extends Controller {
	/**
	 * 获取入口目录
	 * @author Rain <80692285@qq.com>
	 */
	protected function initialize() {
		$base_file = $this -> request -> baseFile();		
		$base_dir = rtrim($base_file, 'index.php');
		$this -> assign('base_dir', $base_dir);
		$this -> assign('static_dir', $base_dir . 'public/static/');

	}

	/**
	 * 安装首页
	 * @author rain <80692285@qq.com>
	 */
	public function index() {
		session('step', null);
		session('error', null);
		session('reinstall', null);
        session('reinstall', true);
		$this -> assign('update', '升级');


		session('step', 1);
		session('error', false);
		return $this -> fetch();
	}    
	public function inUpdate() {
		$param = input('param.');			
		$db = config('database.');
		$db_instance = \Db::connect($db);
		if($param['db_password'] == true && $db['password'] == $param['db_password']){
			$this->updateDb($db_instance,$db['prefix']);
			return '更新成功';
		}
		return '数据库密码不正确！';
		
	}
    protected function updateDb($db,$prefix) {
    	
		//更新后台菜单	
    	$up_meun[361]  = "INSERT INTO `rainos_menu` VALUES ('361', '充值卡管理', '充值卡管理', 'app', 'admin', 'admin/AppRechargeCard/index', '361', '300', 'fa fa-fw fa-credit-card', '1', '', 'on', '0', '0')";
        $up_meun[362]  = "INSERT INTO `rainos_menu` VALUES ('362', '卡类管理', '卡类管理', 'app', 'admin', 'admin/AppRechargeCardType/index', '362', '300', 'fa fa-fw fa-credit-card-alt', '1', '', 'on', '0', '0')";
        $up_meun[363]  = "INSERT INTO `rainos_menu` VALUES ('363', '编辑卡类', '编辑卡类', 'app', 'admin', 'admin/AppRechargeCardType/edit', '363', '300', null, '1', '', 'off', '0', '0')";
        $up_meun[364]  = "INSERT INTO `rainos_menu` VALUES ('364', '添加卡', '添加卡', 'app', 'admin', 'admin/AppRechargeCard/add', '364', '300', null, '1', '', 'off', '0', '0')";
        $up_meun[18]   = "INSERT INTO `rainos_menu` VALUES ('18', '系统日志', '系统日志', 'system', 'admin', 'admin/Log/index', '232', '4', 'si fa-fw si-note', '1', '', 'on', '0', '0')";
        $up_meun[19]   = "INSERT INTO `rainos_menu` VALUES ('19', '黑名单管理', '黑名单管理', 'system', 'admin', 'admin/BlockList/index', '233', '4', 'si fa-fw si-list', '1', '', 'on', '0', '0')";
        $up_meun[192]  = "INSERT INTO `rainos_menu` VALUES ('192', '添加黑名单', '添加黑名单', 'system', 'admin', 'admin/BlockList/add', '192', '19', null, '1', '', 'off', '0', '0')";
        $up_meun[193]  = "INSERT INTO `rainos_menu` VALUES ('193', '编辑黑名单', '编辑黑名单', 'system', 'admin', 'admin/BlockList/edit', '193', '19', null, '1', '', 'off', '0', '0')";
		$up_meun[514]  = "INSERT INTO `rainos_menu` VALUES ('514', '代理商卡管理', '代理商管理设置', 'app', 'admin', 'admin/AppAgentCardInfo/index', '513', '500', null, '1', '', 'off', '0', '0')";
        $up_meun[517]  = "INSERT INTO `rainos_menu` VALUES ('517', '代理商卡设置', '代理商卡数量设置', 'app', 'admin', 'admin/AppAgentCardInfo/setup', '517', '500', null, '1', '', 'off', '0', '0')";
        $up_meun[1250] = "INSERT INTO `rainos_menu` VALUES ('1250', '代理应用', '代理应用', 'app_agent', 'user', 'index/AgentApp/index', '1250', '0', 'fa fa-fw fa-paper-plane', '1', '', 'on', '0', '0')";
        $up_meun[1251] = "INSERT INTO `rainos_menu` VALUES ('1251', '代理商卡管理', '代理商卡管理', 'app_agent', 'user', 'index/AgentInfo/card', '1251', '0', null, '1', '', 'off', '0', '0')";
		
		
		$orginal = config('install.original_table_prefix');
        
		foreach($up_meun as $key=>$value){
			if(!db('menu')->where('id',$key)->find()){
				$value = str_replace(" `{$orginal}", " `{$prefix}", $value);
			    $db->execute($value);
			}
			
		}
		
		//更新表-卡
		if(!$this->isTable($prefix.'apps_recharge_card')){
			$value = "DROP TABLE IF EXISTS `rainos_apps_recharge_card`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_apps_recharge_card` (
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
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8
            ";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}
		//更新表-卡类型
		if(!$this->isTable($prefix.'apps_recharge_card_type')){
			$value = "DROP TABLE IF EXISTS `rainos_apps_recharge_card_type`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			//$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_apps_recharge_card_type` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}
		//更新表-日志
		if(!$this->isTable($prefix.'logs')){
			$value = "DROP TABLE IF EXISTS `rainos_logs`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_logs` (
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
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}		
		//更新表-黑名单
		if(!$this->isTable($prefix.'block_lists')){
			$value = "DROP TABLE IF EXISTS `rainos_block_lists`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_block_lists` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `type` varchar(255) NOT NULL DEFAULT 'ip',
            `value` varchar(255) DEFAULT NULL,
            `comment` text,
            `create_time` int(11) NOT NULL DEFAULT '0',
            `update_time` int(11) NOT NULL DEFAULT '0',
            `status` int(11) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}
		//更新表-在线用户
		if(!$this->isTable($prefix.'apps_user_ws')){
			$value = "DROP TABLE IF EXISTS `rainos_apps_user_ws`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_apps_user_ws` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) DEFAULT NULL,
            `app_id` int(11) DEFAULT NULL,
            `create_time` int(11) NOT NULL DEFAULT '0',
            `update_time` int(11) NOT NULL DEFAULT '0',
            `sum` varchar(255) NOT NULL DEFAULT '1',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}
		//更新表-代理商卡配置
		if(!$this->isTable($prefix.'apps_agent_card_info')){
			$value = "DROP TABLE IF EXISTS `rainos_apps_agent_card_info`";//表
			$value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
			//字段
            $value = "CREATE TABLE `rainos_apps_agent_card_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL DEFAULT '0',
            `app_id` int(11) NOT NULL DEFAULT '0',
            `card_type_id` int(11) NOT NULL DEFAULT '0',
            `rem_num` int(11) NOT NULL DEFAULT '0',
            `create_time` int(11) NOT NULL DEFAULT '0',
            `update_time` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理商卡生成信息配置'";	
            $value = str_replace(" `{$orginal}", " `{$prefix}", $value);		
			$db->execute($value);
		}		
				
		//$this->copy_config();		
		
	}
    //表是否存在
    protected function isTable($table_name){
    	$sql = 'SHOW TABLES LIKE "'.$table_name.'"';
		return \Db::query($sql);
		
    }
	
	protected function copy_config($config){
		if(!is_file(\Env::get('root_path').'/config/database.php')){
			$cofn = file_get_contents(APP_PATH . 'database.php');
			file_put_contents(\Env::get('root_path') . 'config/database.php', $conf);
		}
    }

}
