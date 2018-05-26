<?php
namespace app\index\controller;

use think\Request;
use app\common\controller\Fn;
use Route;
use Config;

class Error extends Base 
{
    /**
    * @cc 模块类公共入口
    *    
    */    
    public function index(Request $request)
    {
        $controllerName = $request->controller();
		
		$actionName = $request->action();
		$paramName = $request->param();
//		echo $moduleName.'|'.$controllerName;
		//dump($actionName);
		$files=glob(APP_PATH.'*/index/'.$controllerName.'.php');
		
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
			$class="\\app\\$dirname\\index\\$controllerName";			
		    $action=new $class;
			return $action->index();		
		}
		$files=glob(ADDON_PATH.'*/index/'.$controllerName.'.php');
		
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
			$class="\\addons\\$dirname\\index\\$controllerName";
		    $action=new $class;
			return $action->index();
		}
	    
//      $class="\\app\\index\\controller\\$controllerName";
//		$action=new $class;
//		return $action->index();
		//var_dump($dirname);
   
        //$action->index();

    }
   
    /**
    * @cc 模块方法公共入口
    *    
    */
    public function _empty(Request $request)
    {
        $controllerName = $request->controller();       
		$actionName = $request->action();
		$paramName = $request->param();
		//echo $moduleName.'|'.$controllerName;
		//var_dump($actionName);
		$files=glob(APP_PATH.'*/index/'.$controllerName.'.php');
		
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];
			$class="\\app\\$dirname\\index\\$controllerName";
		    $action=new $class;
		    $actions="\\$actionName";
		       
            return $action->$actionName();			
		}
		$files=glob(ADDON_PATH.'*/index/'.$controllerName.'.php');
		if($files){
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];
			$class="\\addons\\$dirname\\index\\$controllerName";
		    $action=new $class;
		    $actions="\\$actionName";
		       
            return $action->$actionName();			
		}

						
        
    }
}