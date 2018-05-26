<?php
namespace app\user\index;

use app\index\controller\Base;
use app\user\model\Users;
use Request;
use Session;
use Cookie;

class User extends Base
{
    public function index()
    {
        return 'user';
    }
    public function resetPassword()
    {
      	
        if(!is_login()){
        	$this->redirect('index/User/login');
        }
		return $this->fetch();
    }
	public function inResetPassword(){
		if(!is_login()){
        	return ['code'=>70004,'msg'=>'请先登录'];
        }	
		if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                    'password'     => 'require',
                    'new_password' => 'require|min:5',
                    'en_password'  => 'require|min:5|confirm:new_password',
                ],
                [
                    'password'     => '原始密码不能为空',
                    'new_password' => '新密码至少5位以上字符',
                    'en_password'  => '确认密码至少5位以上字符,并与密码相同',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$indata['user_id'] = session('user_auth.user_id');
            $classdb = new Users();
			$rest = $classdb->inResetPassword($indata);
			return $rest;
					
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');		
		
	}	
    public function register()
    {
        if(is_login()){
        	$this->redirect('index/Index/index');
        }		
        return $this->fetch();
    }
	public function login()
    {
        //dump(config());exit;	
			
        if(is_login()){
        	$this->redirect('index/Index/index');
        }	
        
        return $this->fetch();
    }
	
	public function inLogin()
    {
        if(is_login()){
        	return ['code'=>70004,'msg'=>'您已等录'];
        }		
        if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                'username'   => 'require|length:3,25|chsAlphaNum',
                'password'   => 'require|min:5',
                ],
                [
                'username'     => '用户名必须是汉字,字母或数字',
                'password'     => '密码至少5位以上字符',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$indata['login_ip']=$this->request->ip();
			$users = new Users();
			$rest = $users -> inLogin($indata);
			if($rest['code'] === 1){				
				session('user_auth',['user_id'=>$rest['data']['id'],'user_name'=>$rest['data']['username'],]);
				if(isset($indata['remember_me'])){
					
					cookie('user_auth', session('user_auth'), 24 * 3600 * 7);
				}
			}
			return $rest;
			
			
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');
    }
	
	
	public function inRegister()
	{
		if(is_login()){
        	return ['code'=>70004,'msg'=>'您已等录'];
        }	
		if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                'username'   => 'require|length:3,25|chsAlphaNum',
                //'mobile'     => 'number|length:11',
                'password'   => 'require|min:5',
                'enpassword' => 'require|min:5|confirm:password',
                'register_terms'=>'require',
                ],
                [
                'username'     => '用户名必须是汉字,字母或数字',
                //'mobile'       => ['code'=>70002,'msg'=>'fail','content'=>'手机号码必须是11位长度数字'],
                'password'     => '密码至少5位以上字符',
                'enpassword'   => '确认密码至少5位以上字符,并与密码相同',
                'register_terms'   => '未同意条款',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$indata['create_ip']=$this->request->ip();
			$register = new Users();
			$rest = $register -> inRegister($indata);
			return $rest;
			
			
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');
	}
    
	public function quit(){
		session(null);
		cookie('user_auth', null);
    	return $this->redirect('index/User/login');
    }
}
