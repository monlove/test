<?php
namespace app\admin\controller;

use app\common\controller\Common;
use Request;
use Config;
use app\admin\model\Modules;

class Module extends Base
{
	/**
     * @node 模块管理
	 * @module 系统
     *
     */	
    public function index()
    {
        return $this->fetch();
    }
	/**
     * @node 模块列表
	 * @module 系统
     *
     */		
    public function lists(){
        $draw=input('param.draw');
		
    	$name=[];
		foreach(glob(APP_PATH.'*/info.php') as $module_info){
			// 格式化路径信息
            $info = pathinfo($module_info);
			// 获取模块目录名
            $name = pathinfo($info['dirname'], PATHINFO_FILENAME);
			$resconfig[]=Config::load($module_info,$name.'_module');			
		}
		foreach($resconfig as $key=>$val){
			$rest = Modules::get(['name'=>$val['name']]);
			$resconfig[$key]['is_install'] = 0;
			$resconfig[$key]['is_update']  = 1;
			if($rest){
				$resconfig[$key]['is_install'] = 1;
				if($resconfig[$key]['version'] !== $rest['version']){
					$resconfig[$key]['is_update']  = 0;
				}
				$resconfig[$key]['status']  = $rest['status'];
			}
		}
		$resconfig = list_sort_by($resconfig,'is_system','asc');
		
    	$count=count($resconfig);
    	return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$resconfig];
    }
	/**
     * @node 安装
	 * @module 系统
     *
     */	
    public function install(){
		if (Request::instance() -> isAjax()) {
			$name = input('post.name');
		    $dirname=strtolower($name);
    	    $class="\\app\\$dirname\\Fn";
		    $action=new $class;
		    $res =$action->install();
			$this->success('插件安装成功');
		}	
		   	   	
    }
	/**
     * @node 卸载
	 * @module 系统
     *
     */		
    public function unInstall(){
		if (Request::instance() -> isAjax()) {
			$name = input('post.name');
		    $dirname=strtolower($name);
    	    $class="\\app\\$dirname\\Fn";
		    $action=new $class;
		    $res =$action->uninstall();
            $this->success('插件已卸载');
		}	
		   	   	
    }  	
}
