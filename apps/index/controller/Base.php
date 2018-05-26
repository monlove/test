<?php
namespace app\index\controller;

use Session;
use Cookie;
use think\Controller;
use Config;
use Request;
use auth\Auth;
use app\user\model\Users;
use app\user\model\Menu;
use app\admin\model\Systems;
use app\common\controller\Common;
use app\common\controller\Fn;
use app\page\model\PagesTheme;
use app\page\model\PagesNav;
use app\page\model\Pages;
use app\page\model\PostsSort;
use app\page\model\Posts;
use app\app\model\AppsAgent;

class Base extends Controller
{
    public function initialize()
    {
    	
		if (Request::instance()->isPjax()){
        	Config::set('default_ajax_return','html');
        	
        }
        
		$is_login = is_login();
		//var_dump($is_login);
		$user_info = null;
		if($is_login){
			$user_info = Users::get($is_login);
			$auth = Auth::instance();			
            $user_info['role'] = $auth->getGroups($is_login);			
			$user_info['create_date']     = date('Y-m-d',strtotime($user_info->create_time));
			$user_info['update_date']     = date('Y-m-d',strtotime($user_info->update_time));
			$user_info['login_date']      = date('Y-m-d',$user_info->login_time);
          	$user_info['last_login_date'] = date('Y-m-d',$user_info->last_login_time);
		}
		
		$themedb = PagesTheme::get(['name'=>'theme_path']);		
		$resdb   = PagesTheme::all(['type'=>$themedb['value']]);
		$data =[];
		foreach($resdb as $key=>$val){
			$data[$resdb[$key]['name']]=$resdb[$key]['value'];
		}
		$themedb['data'] = $data;
		$themedb['class'] =	ucfirst($themedb['path']);
		
		$page_nav = PagesNav::all(['status'=>1]);
		$page_nav=$page_nav -> toArray();
		//dump($data);exit;
		$navlist=[];
		if($page_nav){
			$navlist = menuSort($page_nav);
		}
		
		foreach($navlist as $key=>$val){
			$navlist[$key]['is_level'] = 'off';
			$is_level = PagesNav::get(['parent_id'=>$navlist[$key]['id']]);
			if($is_level){
				$navlist[$key]['is_level'] = 'on';
			}
		    if($navlist[$key]['type'] === 'index'){
		    	$navlist[$key]['url'] = url('index/Index/index');
		    }
			
			if($navlist[$key]['type'] === 'app'){
		    	$navlist[$key]['url'] = url($navlist[$key]['url']);
		    }
			if($navlist[$key]['type'] === 'page'){
				$pages = Pages::get(['id'=>$navlist[$key]['type_id']]);
				$urldata = url('index/Page/index',['id'=>$navlist[$key]['type_id']]);
				
				if($pages['url_name']){
					$urldata = url('index/Page/index',['name'=>$pages['url_name']]);
				}
				$navlist[$key]['url'] = $urldata;
			}else if($navlist[$key]['type'] === 'sort'){
				$navlist[$key]['url'] = url('index/PostSort/index',['id'=>$navlist[$key]['type_id']]);
			}
			
		}
		
		$this->assign('themedb',$themedb);
					
		$this->assign('user_info',$user_info);
		//dump($user_info['icon']);exit;
		$this->assign('navlist',$navlist);

		$post_hot = Posts::where(['status'=>1])->order('access_num desc')->paginate(10);		
		foreach($post_hot as $key=>$val){
			$post_hot[$key]['content'] = preg_replace('!<[^>]*?>!', ' ', $post_hot[$key]['content']);
			$post_hot[$key]['url'] = url('index/Post/index',['id'=>$post_hot[$key]['id']]);

		}
		$post_top = Posts::where(['status'=>1,])->order('top desc')->paginate(6);
		foreach($post_top as $key=>$val){
			$post_top[$key]['content'] = preg_replace('!<[^>]*?>!', ' ', $post_top[$key]['content']);
			$post_top[$key]['url'] = url('index/Post/index',['id'=>$post_top[$key]['id']]);
			if(empty($post_top[$key]['featured_image'])){
				$s = ('photo' . rand(1, 39) . '.jpg');
				$post_top[$key]['featured_image'] = '__ONEUI__/img/photos/'.$s;
			}

		}						
		$this->assign('post_top',$post_top);		
		$this->assign('post_hot',$post_hot);
		

		if($is_login){
		//usermenu
		    $node = new Fn;
		    $node = $node -> getNode();
		    $this->assign('node',$node);		
		    $where = ['position'=>'user','show'=>'on'];
		    $user_menu = Menu::where($where)->select();//用户中心导航菜单
		    $user_page = Menu::where('node',$node)->find();//用户中心当前页面			
			
			$app_agent = AppsAgent::where(['user_id'=>$is_login,'status'=>1])->find(); 
			if(empty($app_agent)){
		        foreach($user_menu as $k=>$v){
			        if($user_menu[$k]['module'] == 'app_agent'){
			        	unset($user_menu[$k]);
			        }			        	
		        }			
			}

		    $this->assign('user_page',$user_page);
		    $this->assign('user_menu',$user_menu);						
		}

				

		
		
		
		
    }



}
