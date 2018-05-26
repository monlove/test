<?php
namespace app\user\model;

use think\helper\Hash;
use think\Model;
use auth\Auth;
use think\helper\Time;
use app\user\model\AuthGroupAccess as AuthGa;
use Cookie;
use App;

class Users extends Model
{
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	
	public function inRegister($data){
		//手机号加密 /检测用户是否存在 /检测手机号是否存在
		//$data['mobile']=encode($data['mobile'],config('sys_config.rain_key'));		
		$resuser   = $this -> where('username',$data['username'])->find();		
		//$resmobile = $this -> where('mobile',$data['mobile'])->find();
		
		if($resuser){//用户存在
			return ['code'=>33,'msg'=>'用户名已存在'];
		}
		//if($resmobile){//手机号存在
			//return ['code'=>70007,'msg'=>'fail','content'=>'手机已被使用,可通过此手机号找回密码'];
		//}
		//检测注册的IP是否注册过
		$rescreateip = $this -> where('create_ip',$data['create_ip'])->find();
		if($rescreateip){//IP注册过,提定时间不许再注册
			if(floor(App::getBeginTime()) < (strtotime($rescreateip->create_time) + config('sys_config.register_limit')*60)){				
				return ['code'=>0,'msg'=>'请不要重复注册'];
			}
		}		
		$data['password']=Hash::make((string)$data['username'].$data['password']);		
		$this->data($data);
		$this->allowField(true)->save();
		$authga = new AuthGa();
		$authga->setUserRole($this->id,2);
		if(Cookie::has('agent_tn')){
			$user_id =$this->id;
			$agent_tn = Cookie::get('agent_tn');
			$user_db = $this->where('username',$agent_tn)->find();
			
			if(class_exists('app\app\model\AppsAgentUser')){
								
			    \app\app\model\AppsAgentUser::create(['user_id'=>$user_id,'agent_user_id'=>$user_db['id']]);
			}

		}
		$resdata = ['username'=>$data['username'],'user_id'=>$this->id,'password'=>$data['enpassword']];
		in_log(['type'=>'register','user_id'=>$this->id]);
		return ['code'=>1,'msg'=>'用户创建成功','data'=> $resdata];
		
	}
	
	public function inLogin($data){		
		$resuser = $this -> where('username',$data['username'])->find();
		if($resuser){//用户存在-效验密码
			if(Hash::check((string)$data['username'].$data['password'],$resuser->password)){
				$this->save([
                    'login_time'  => floor(App::getBeginTime()),
                    'login_ip' => $data['login_ip'],
                    'last_login_time' => $resuser->login_time,
                    'last_login_ip' => $resuser->login_ip,
                ],['id' => $resuser->id]);
				$this->where('id',$resuser->id)->setInc('login_count');
				in_log(['type'=>'login','user_id'=>$resuser->id]);				
				return ['code'=>1,'msg'=>'登录成功','data'=>['id'=>$resuser->id,'username'=>$resuser->username,]];
			}
			return ['code'=>80001,'msg'=>'密码不正确'];
		}
		return ['code'=>80001,'msg'=>'用户不存在'];
		
	}
	
	public function inEditPassword($data){
		$resuser = $this -> where('username',$data['username'])->find();
		if($resuser){//用户存在-效验密码
			if(Hash::check((string)$data['username'].$data['oldpassword'],$resuser->password)){
                $data['password'] = Hash::make((string)$data['username'].$data['password']);
				$this->save(['password'  => $data['password']],['id' => $resuser->id]);			
				return ['code'=>1,'msg'=>'修改成功','data'=>['id'=>$resuser->id,'username'=>$resuser->username]];
			}
			return ['code'=>80001,'msg'=>'密码不正确'];
		}
		return ['code'=>80001,'msg'=>'用户不存在'];
	}

	public function inResetPassword($data){
		$resuser = $this -> where('id',$data['user_id'])->find();
		if($resuser){//用户存在-效验密码
			if(Hash::check((string)$resuser['username'].$data['password'],$resuser->password)){
                $data['new_password'] = Hash::make((string)$resuser['username'].$data['new_password']);
				$this->save(['password'  => $data['new_password']],['id' => $resuser->id]);			
				return ['code'=>1,'msg'=>'修改成功','data'=>['id'=>$resuser->id,'username'=>$resuser->username,]];
			}
			return ['code'=>80001,'msg'=>'原始密码不正确'];
		}
		return ['code'=>80001,'msg'=>'用户不存在'];
	}
	
	public function getNewUser($time='today'){
		//$ts = Time::week();
		//dump(timeTodate($ts[0]));
		//dump(timeTodate($ts[1]));
		$start_time = Time::$time();
		$total = $this->count();
		$count = $this->where('create_time','>',$start_time[0])->where('create_time','<',$start_time[1])->count();
		$auth_count = $this->where('auth_time','>',$start_time[0])->where('auth_time','<',$start_time[1])->count();
		$restdb = $this->where('create_time','>',$start_time[0])->where('create_time','<',$start_time[1])->order('id desc')->limit(1,20)->select();
		$percent = ceil($count/$total*100);	
		$userdb = ['count'=>$count,'userlist'=>$restdb,'percent'=>$percent,'auth_count'=>$auth_count];
		return $userdb;
	}
	public function getNewUserDay($day){
		//$ts = Time::week();
		//dump(timeTodate($ts[0]));
		//dump(timeTodate($ts[1]));
		$start_time = [0=>time()-$day*86400,1=>time()];
		$total = $this->count();
		$count = $this->where('create_time','>',$start_time[0])->where('create_time','<',$start_time[1])->count();
		$auth_count = $this->where('auth_time','>',$start_time[0])->where('auth_time','<',$start_time[1])->count();
		$restdb = $this->where('create_time','>',$start_time[0])->where('create_time','<',$start_time[1])->order('id desc')->limit(1,20)->select();
		$percent = ceil($count/$total*100);	
		$userdb = ['count'=>$count,'userlist'=>$restdb,'percent'=>$percent,'auth_count'=>$auth_count];
		return $userdb;
	}
	public function getNewUserNum($num)
    {
        $resdb = $this->order('id desc,status')->page('1,$num')->select();
		return $resdb;
    }    	

}
