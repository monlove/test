<?php
namespace app\common\behavior;

use Request;
use app\page\model\PagesTheme;
use app\admin\model\Menu;
use think\Controller;

class ThemeConfig
{
	/*
	 * @name 动态配置
	 * 
	 */   
    public function run(Request $request, $params)
    {
        $classdb = new PagesTheme();
     
        $request    = Request::instance();
		$module     = $request->module();
		$controller = $request->controller();
		$action     = $request->action();
		$param      = $request->param();
				
        if($module === 'index' && is_file(\Env::get('root_path').'/config/database.php')){       	
			$configdb = $classdb->where('name','theme_path')->find();		    
            $controllerName = $request->controller();
		    $files=glob(APP_PATH.'*/index/'.$controllerName.'.php');
		    config('template.view_path','./theme/'.$configdb['path'].'/index/');
		    if($files){
			    $dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
				config('template.view_path','./theme/'.$configdb['path'].'/'.$dirname.'/');
			}
						
        }
        
		if($module === 'admin'){       	
			$configdb = Menu::where('node',$module.'/'.$controller.'/'.$action)->find();
			
			if($configdb['module'] !== 'admin' && $configdb['module'] !== 'system'){
				config('template.view_path','./apps/'.$configdb['module'].'/admin_view/');				
			}

       }
		
    }
	
}
