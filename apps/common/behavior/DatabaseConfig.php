<?php
namespace app\common\behavior;

use think\Db;
use Request;
use app\admin\model\Configs;

class DatabaseConfig
{
	/*
	 * @name 动态配置
	 * 
	 */   
    public function run(Request $request, $params)
    {
        $configs = new Configs();

        $request    = Request::instance();
		$module     = $request->module();
		$controller = $request->controller();
		$param      = $request->param();
		//echo $module.'/'.$controller;
        if($module === 'admin' && $controller === 'Database' || $controller === 'System'){
        	
			$configdb = $configs->where('group','database')->select();
			foreach($configdb as $key=>$val){
				$config[$configdb[$key]['name']] = $configdb[$key]['value'];
			}
			config($config,'data_set');
			
			//exit;
			
        }
		
    }
}
