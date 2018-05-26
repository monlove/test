<?php
namespace app\common\behavior;

use think\facade\Request;
use app\admin\model\Configs;

class GlobalConfig {
	/*
	 * @name 动态配置
	 *
	 */
	public function run(Request $request, $params) {
		if(!is_file('./public/data/install.lock')){
            config('app.default_module','install');
			
        }			        
		if(is_file('./public/data/install.lock') && is_file(\Env::get('root_path').'/config/database.php')){						
			$configs = new Configs();
			$global_config = $configs -> where('group', 'global') -> select();
			foreach ($global_config as $keys => $vals) {
				$config[$global_config[$keys]['name']] = $global_config[$keys]['value'];
			}
			config($config,'site');

		}

	}

}
