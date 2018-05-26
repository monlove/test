<?php
namespace app\admin\controller;

use Session;
use think\Controller;
use Request;
use auth\Auth;
use Cache;
use app\common\controller\Common;
use app\common\controller\Fn;
use App;

class Base extends Controller
{
    public function initialize(){
    	
		//echo $moduleName.'|'.$controllerName;
			
		if(empty(is_login())){
			$this->redirect('index/User/login');
			exit;
		}
        if(1 != session('user_auth.user_id')){
        	$chkdb = request()->module().'/'.request()->controller().'/'.request()->action();
		    $auth = new Auth();
		    if(!$auth->check($chkdb,session('user_auth.user_id'))){
			    $this->error('您没有访问权限...');
		    }	
        }
	
				
		$menus = new Common();
        $menu=$menus->getPositionMenu('admin');
		$authinfo = $menus->getAuthFile();
		$this -> assign('authinfo',$authinfo);
		
		$fn = new Fn();
		$node=$fn->getNode();
        //var_dump($fn->getAction());
		$actiondb     = $menus->getActionDb($node);
		if(empty($actiondb)){//不在数据表中就指定index为节点
			$node = $fn->getIndex();
			$actiondb = $menus->getActionDb($node);						
		}
		$controllerdb = $menus->getParentDb($actiondb['parent_id']);
		$moduledb     = $menus->getParentDb($controllerdb['parent_id']);

		$top_id='';	
		foreach($menu as $kx=>$vx){
			$menu[$kx]['module_li_class']='';
			$menu[$kx]['cont_class']='';
			$menu[$kx]['cont_li_class']='';
			$menu[$kx]['action_li_class']='';
			$menu[$kx]['cont_li_class']='';	
		}
		
		foreach ($menu as $k=>$v){						
			if($menu[$k]['node']===$node){
				$menu[$k]['action_li_class']='active';
			   	$module=$menu[$k]['module'];
				foreach($menu as $key=>$val){
					if($menu[$key]['module']===$module && $menu[$key]['parent_id'] < 1){
						$menu[$key]['module_li_class']='active';
						$top_id=$menu[$key]['id'];
					}
				}
				foreach($menu as $kc => $vc){
                    if($menu[$k]['parent_id']===$menu[$kc]['id']){
                    	$menu[$k]['cont_class']='open';
						$menu[$kc]['cont_class']='open';
						$menu[$k]['cont_li_class']='open';	
						$menu[$kc]['cont_li_class']='open';	
                        foreach($menu as $ka =>$va){
						    if($menu[$kc]['parent_id']===$menu[$ka]['id']){
							    $menu[$k]['cont_class']='open';
							    $menu[$ka]['cont_class']='open';
							    $menu[$kc]['cont_class']='open';
								$menu[$k]['cont_li_class']='open';	
								$menu[$ka]['cont_li_class']='open';	
							    $menu[$kc]['cont_li_class']='open';						        
						    }
					    }
                    }
				}												
			}			
		}
        	
		$menu=menuSort($menu);
		
		//dump($menu);
		//exit;
		//$menu['38']['controller_li_class']='open';
		$params = $this->getAuthData();		
		$confile = \Env::get('root_path').'runtime/'.md5($params['domain']).'.key';		
		if(!file_exists($confile)){
			$authinfo = ['code'=>0 ,'author_type'=>'未授权'];
        }else{       	
        	$str = file_get_contents($confile);		
		    $rest = rain_decrypt($str,\Config::get('rainos.rain_key'));
		    $rest_db = json_decode($rest,TRUE);
			    
		    if($params['domain'] == $rest_db['domain']){
			    $authinfo = ['code'=>1 ,'author_type'=>$rest_db['author_type']];
			    if($rest_db['author_type'] == 'not'){
				    $authinfo['author_type'] = '未经授权';
			    }
			    if($rest_db['author_type'] === 'free'){
				    $authinfo['author_type'] = '免费版';
			    }			
			    if($rest_db['author_type'] === 'business'){
				    $authinfo['author_type'] = '商业版';
			    }			
		    }else{
			    $authinfo = ['code'=>0 ,'author_type'=>'not'];
		    }
        }
		
		$this->assign('authinfo',$authinfo);
		config('site_check',$rest_db);
		$this->assign('actiondb',$actiondb);
		$this->assign('controllerdb',$controllerdb);
		$this->assign('moduledb',$moduledb);
		$this->assign('menu',$menu);
		$this->assign('top_id',$top_id);
		
		
    }

    /**
     * @node 文件上传
     *
     *
     * @return string 注释
     *
     */
	public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $file_dir=\Env::get('root_path') . 'public' . DIRECTORY_SEPARATOR . 'uploads'.DIRECTORY_SEPARATOR.session('user_auth.user_name');
        $info = $file->move($file_dir);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
             $imgurl=str_replace("\\","/",$info->getSaveName());
            return $imgurl;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
    /**
     * @node 编辑器上传
     *
     *
     * @return string 注释
     *
     */
	public function editupload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('upload');
		//dump($file);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $file_dir = \Env::get('root_path') . 'public' . DS . 'uploads' . DS . session('user_auth.user_name');
		
        $info = $file->move($file_dir);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $imgname=str_replace("\\","/",$info->getSaveName());
			$request = Request::instance();
			$imgurl = $request->root().'/public/uploads/'.session('user_auth.user_name').'/'.$imgname;
			$rest = ['errno'=>0,'data'=>[$imgurl]];
			$ckeditnum = input('param.CKEditorFuncNum');
			//dump($ckeditnum);
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($ckeditnum,'".$imgurl."','');</script>";  
            //return $rest;
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
    
	public function reAuth(){
		$common = new Common();
		$authinfo = $common->resteAuthFile();
		$this->success('读取成功,请刷新页面');
	}	
    protected function getAuthData(){
    	$request = Request::instance();
		$domain = $request->domain();
	    $data = ['site_app_id'=>1,'domain'=> get_domain($request->domain())];
		return $data;
	}

}
