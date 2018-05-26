<?php
namespace app\common\behavior;

use Request;
use app\page\model\PagesTheme;
use think\Controller;

class ThemeHook
{
	/*
	 * @name 动态配置
	 * 
	 */   
    public function run(Request $request, $params)
    {
		
    }
	
	static public function call($type , $name , &$array = array())
    {
    	$thpath = db('pages_theme')->where('name','theme_path')->find();
		$themedb = db('pages_theme') ->where('type',$thpath['value'])->select();
		$files=glob(\Env::get('root_path').'theme/'.$thpath['path'].'/method/*.php');
		$path = $thpath['path'];
					
		if($files){			
			$dirname=pathinfo(dirname(dirname($files[0])))['basename'];	
			$class="\\theme\\$path\\method\\$type";			
		    $action=new $class();
			return $action->$name($array);
		}

    }
}
