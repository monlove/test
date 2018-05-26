<?php
namespace app\admin\controller;

use think\Request;
use app\common\controller\Fn;
use Route;
use Config;

class Error extends Base 
{
    /**
     * @node 空控制器
     *
     *
     * @return string 注释
     *
     */   
    public function index(Request $request)
    {
        $controllerName = $request->controller();
		$actionName = $request->action();
		$paramName = $request->param();
		//echo $moduleName.'|'.$controllerName;
		//var_dump($actionName);
		$files=glob(APP_PATH.'*/admin/'.$controllerName.'.php');
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
			$class="\\app\\$dirname\\admin\\$controllerName";
		    $action=new $class;								
			return $action->index();		
		}
		$files=glob(ADDON_PATH.'*/admin/'.$controllerName.'.php');
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
			$class="\\addons\\$dirname\\admin\\$controllerName";
		    $action=new $class;
			return $action->index();
		}

		//var_dump($dirname);
   
        //$action->index();

    }
   
    /**
     * @node 空操作
     *
     *
     * @return string 注释
     *
     */
    public function _empty(Request $request)
    {
        $controllerName = $request->controller();
		$actionName = $request->action();
		$paramName = $request->param();
		//echo $moduleName.'|'.$controllerName;
		//var_dump($actionName);
		$files=glob(APP_PATH.'*/admin/'.$controllerName.'.php');
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];
			$class="\\app\\$dirname\\admin\\$controllerName";
		    $action=new $class;
		    $actions="\\$actionName";			    	    
            return $action->$actionName();			
		}
		$files=glob(ADDON_PATH.'*/admin/'.$controllerName.'.php');
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];
			$class="\\addons\\$dirname\\admin\\$controllerName";
		    $action=new $class;
		    $actions="\\$actionName";
		       
            return $action->$actionName();			
		}
						
        
    }
}