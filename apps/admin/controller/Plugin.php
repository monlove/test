<?php
namespace app\admin\controller;

use app\common\controller\Common;
use Request;
use Config;
use app\admin\model\Plugins;

class Plugin extends Base
{
	/**
     * @node 插件管理
	 * @module 系统
     *
     */	
    public function index()
    {
        return $this->fetch();
    }
	/**
     * @node 插件列表
	 * @module 系统
     *
     */		
    public function lists(){
        $draw=input('param.draw');
		
    	$name=[];
		foreach(glob(ADDON_PATH.'*/*.php') as $plug_info){
			// 格式化路径信息
            $info = pathinfo($plug_info);
			// 获取模块目录名
			if($info['basename'] !== 'config.php'){
				$filename=$info['filename'];
                $name = pathinfo($info['dirname'], PATHINFO_FILENAME);
			    $class="\\addons\\$name\\$filename";
			    $action=new $class;
			    if($action->info){
				    $resconfig[]=$action->info;	
			    }
			}											
		}
		foreach($resconfig as $key=>$val){
			$rest = Plugins::get(['name'=>$val['name']]);
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
    	    $class="\\addons\\$dirname\\$name";
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
    	    $class="\\addons\\$dirname\\$name";
		    $action=new $class;
		    $res =$action->uninstall();
            $this->success('插件已卸载');
		}	
		   	   	
    }    
}
