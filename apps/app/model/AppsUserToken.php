<?php
namespace app\app\model;

use think\Model;
use app\user\model\Users;
use Session;
use think\helper\Hash;
use App;


class AppsUserToken extends Model
{
    public function getToken($data){
    	$user = new Users();				
		$resuser = $user -> where('username',$data['username'])->find();
		if($resuser){//用户存在-效验密码
		    
			if(Hash::check((string)$data['username'].$data['password'],$resuser->password)){
				if($resuser['status'] < 1){
					return ['code'=>20021,'msg'=>'用户已停用'];
				}
				$tokens = $this->where('user_id',$resuser->id)->where('app_id',$data['app_id'])->find();
				if($tokens){
					if($tokens->expire_time < App::getBeginTime()){							
						$update = ['token' => md5($resuser->id.$data['username'].App::getBeginTime()),'expire_time' => ceil(App::getBeginTime() + 7200)];
						$this->allowField(true)->save($update,['id' => $tokens->id]);
						$tokendb['token'] = $update['token'];
						$tokendb['expire_time'] = $update['expire_time'];
					}else{
						$tokendb['token'] = $tokens->token;
						$tokendb['expire_time'] = $tokens->expire_time;
					}
					
				}else{
					$tokendb = [
						'user_id'     => $resuser->id,
						'app_id'      => $data['app_id'],
						'token'       => md5($resuser->id.$data['username'].App::getBeginTime()),
						'expire_time' => ceil(App::getBeginTime() + 7200)
					];
					$this->data($tokendb);
                    $this->save();
				}
				
				$datas = [
				    'id'           => $resuser->id,
				    'username'     => $resuser->username,
				    'display_name' => $resuser->display_name,
				    'email'        => $resuser->email,
				    'score'        => $resuser->score,
				    'icon'         => $resuser->icon,
				    'comment'      => $resuser->comment,
				    'token'        => $tokendb['token'],
				    'token_expire' => $tokendb['expire_time'],
				];
				in_log(['type'=>'login','user_id'=>$resuser->id,'comment'=>'APP_API']);								
				return ['code'=>1,'msg'=>'取令牌成功','data'=>$datas];
			}
			return ['code'=>20022,'msg'=>'密码不正确'];
		}
		return ['code'=>20023,'msg'=>'用户不存在'];		
	}

	public function users(){
		return $this->hasMany('\\app\\user\\model\\Users','id','user_id');
	}
	public function user(){
		return $this->hasOne('\\app\\user\\model\\Users','id','user_id');
	}
}
