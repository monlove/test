<?php

namespace app\app;

use think\Controller;
use Request;
use app\admin\controller\Base;
use app\admin\model\Modules;
use Config;

class Fn extends Base {
	
	public function install() {
		if (Request::instance() -> isAjax()) {
			$db = config('database.');
			$module_info = Config::load(APP_PATH.'app/info.php','app_module');
			$module = new Modules($module_info);
            // 过滤post数组中的非数据表字段数据
            $module->allowField(true)->save();			
			$this -> create_tables($db['prefix']);
			$this -> success('模块安装成功');
		}
		$this -> error('非法请求');
	}

	public function uninstall() {
		if (Request::instance() -> isAjax()) {
        	$db = config('database');
			$prefix = $db['prefix'];
			$sql = file_get_contents(APP_PATH . 'app/data/uninstall.sql');
			$sql = str_replace("\r", "\n", $sql);
		    $sql = explode(";\n", $sql);
			$orginal = 'rainos_';			
			$sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);			
			foreach ($sql as $value) {
				\Db::execute($value);
			}
			$module_info = Config::load(APP_PATH.'app/info.php','app_module');
			Modules::destroy(['name' => $module_info['name']]);
			\app\admin\model\Menu::destroy(['module' => 'app']);
            \app\user\model\AuthRule::destroy(['module' => 'app']);
			$this -> success('模块已卸载');
		}
		$this -> error('非法请求');	
	}

	protected function create_tables($prefix = '') {

		$sql = file_get_contents(APP_PATH . 'app/data/install.sql');

		$sql = str_replace("\r", "\n", $sql);
		$sql = explode(";\n", $sql);

		// 替换表前缀
		$orginal = 'rainos_';
		$sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

		// 开始安装
		//show_progress('0%');
		$all_table = 511;
		$i = 1;
		foreach ($sql as $value) {
			//dump($value);
			$value = trim($value);
			if (empty($value))
				continue;
			//$msg = (int)($i / $all_table * 100) . '%';
			if (false !== \Db::execute($value)) {
				
			} else {
				//show_progress($msg, 'error');
				//session('error', true);
				$this -> error('$value');
			}
			$i++;
		}

	}

}
