<?php
namespace app\page\admin;

use app\admin\model\Configs;
use app\admin\controller\Base;
use app\page\model\PagesTheme;
use think\Config;
use app\common\behavior\ThemeHook;
use think\Hook AS thinkHook;


class PageConfig extends Base
{
    /**
     * @node 界面设置
	 * 
     *
     */		
    public function index()
    {
      
	    $themedb =PagesTheme::get(['name'=>'theme_path']);
		$resdb = PagesTheme::all(['type'=>$themedb['value']]);
		$data =[];
		foreach($resdb as $key=>$val){
			$data[$resdb[$key]['name']]=$resdb[$key]['value'];
		}
		$themedb['data'] = $data;
		$themedb['class'] =	ucfirst($themedb['path']);
		
		$this->assign('themedb',$themedb);	
        return $this->fetch();
    }
    /**
     * @node 保存设置
	 * 
     *
     */		
    public function inConfig()
    {
        if(\Request::instance()->isPost()){
		    $inputs = input('post.');
            $themedb =PagesTheme::get(['name'=>'theme_path']);
            foreach($inputs as $name => $value){
                $rest = PagesTheme::get(['name'=>$name,'type'=>$themedb['value']]);
				if($rest){
					$rest->value=$value;
					$rest->save();
				}else{
					 User::create(['name'  =>  $name,'type' => $themedb['value'],'value'=>$value]);
				}
            }
						
        }	 
        return ['code'=>1,'msg'=>'保存成功'];
    }
    /**
     * @node 主题设置
	 * 
     *
     */		
    public function theme()
    {		
		$theme_dir=[];
		$themedb = PagesTheme::get(['name'=>'theme_path']);
		//dump($themedb->path);exit;
		foreach(glob(\Env::get('root_path').'theme/*/info.php') as $theme_info){
			// 格式化路径信息
            $info = pathinfo($theme_info);
			$dirname=pathinfo(dirname($theme_info[0]))['basename'];
			// 获取主题目录名
            $theme_dir = pathinfo($info['dirname'], PATHINFO_FILENAME);
			$themes_config = \Config::load($theme_info,$theme_dir.'_theme');
			$themes_config['dir_name'] = $theme_dir;
			$themes_config['screenshot'] = \Request::root().'/theme/'.$theme_dir.'/screenshot.png';
			if (!is_file(\Env::get('root_path').'theme/'.$theme_dir.'/screenshot.png')) {
				$themes_config['screenshot'] = \Request::root().'/public/static/img/screenshot.png';				
			}
			$themes_config['active'] = '';
			if($themedb->path == $theme_dir){
				$themes_config['active'] = 'yes';
			}
			$theme_config[]  = $themes_config;
		}

		//dump($theme_config);exit;	
		$this->assign('theme_config',$theme_config);	
        return $this->fetch();
    }
    /**
     * @node 保存主题设置
	 * 
     *
     */		
	public function active()
	{
		if(\Request::instance()->isPost()){
			
			$restdb=PagesTheme::get(['name'=>'theme_path']);
			$restdb->path = input('param.name');
			$restdb->save();
			return restApi(1,'设置成功',['tmeme_path'=>input('param.name')]);
			
		}
	}

}
