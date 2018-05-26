<?php
// +----------------------------------------------------------------------
// | thinkphp5 Addons [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.rain68.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <80692285@qq.com>
// +----------------------------------------------------------------------
namespace theme\defaults\method;

use think\Db;
use think\Session;
use think\Controller;
use app\common\controller\Theme;

/**
 * 插件测试
 * @author byron sampson
 */
class Defaults extends Theme
{
    public $info = [
        'name' => 'Defaults',
        'title' => '默认主题',
        'description' => '默认主题',
        'status' => 1,
        'author' => 'By Rain',
        'version' => '2.0',
        'appcenter_id'=>25
    ];
     public $hooks = [
        'theme_cog'
    ];
    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * 实现的testHook钩子方法
     * @return mixed
     */
    public function themeconfig($data) // 这里可以通过钩子来调用钩子模板
    {
        	
        $this->assign('themedb',$data);		
               
        $this->fetch('themecog');
  
    }
	
	public function themesave(){
		
		
    }
	
}

