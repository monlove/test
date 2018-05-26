<?php

namespace app\app\controller;

use think\Controller;
use think\Request;
use think\helper\Hash;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsConsts;
use app\app\model\AppsVariables as AppsVar;
use app\app\model\AppsUserVar;
use app\app\model\AppsUserToken as UserToken;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use App;
use Validate;

/**
 * @title 用户应用认证
 * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
 * @param name:app_id type:int require:1 default:1 other: desc:应用ID
 */
class UserApi extends Controller
{
	/**
     * 开发者密钥
     * @var $developer_key
     */	
	protected $developer_key;
	/**
     * 开发者id
     * @var $developer_id
     */	
	protected $create_user_id;
		/**
     * 开发者id
     * @var $developer_id
     */	
	protected $app_crypt;
	/**
     * 构造	
     * 
     */			
	public function __construct(Request $request)
    {
        if(input('?get.app_id') && input('param.app_id')){
        	$appdb = $this->getApps(input('param.app_id'));
			if($appdb){
				//$devedb = $this->getDeve($appdb['create_user_id']);
				$this->app_crypt=$appdb['crypt'];
			}
			$this->developer_key = config('site.site_key');
			//$this->create_user_id = $appdb['create_user_id'];
        }	
        
    }
    /**
     * @title 取用户令牌(登录)
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/getusertoken
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     * @param name:username type:string require:1 default:null other: desc:用户名
	 * @param name:password type:string require:1 default:1 other: desc:用户密码
	 * 
     * @return id:用户ID
     * @return username:用户名称
     * @return display_name:显示名称
	 * @return email:用户邮箱
	 * @return score:用户积分
	 * @return icon:用户图标
	 * @return comment:备注
	 * @return token:令牌(通讯使用)
	 * @return token_expire:令牌过期时间
     */	
	public function getUserToken(Request $request){		
        if($request->isGet()){
			$inputs=input('param.');
			$validate = Validate::make(
			    [
                'app_id'     => 'require|integer',
                'secret_key' => 'require',  
                'username'   => 'require|length:3,25|chsAlphaNum',
                'password'   => 'require|min:5',
                ],
                [
                'app_id'       => '应用ID不能为空',
                'secret_key'   => 'secret key 不能为空', 
                'username'     => '用户名必须是汉字,字母或数字',
                'password'     => '密码至少5位以上字符',
                ]
            );

            if (!$validate->check($inputs)) {
            	return appApi(0,$validate->getError());               
            }
												
			$appdb   = new Apps();
            $restapp = $appdb->where('id', $inputs['app_id'])
	        ->where('secret_key', $inputs['secret_key'])
		    ->field('create_user,secret_key',true)
            ->find();
	        if($restapp){
			    if($restapp['status'] < 1){
				    return appApi(0,'应用已停用');
			    }

	            $tokendb = new UserToken();
				$resdb = $tokendb->getToken($inputs);
				if($resdb['code'] == 1){
					$datas = $this->enBaseAuth($resdb['data'],$this->app_crypt);
					return appApi(1,$resdb['msg'],$datas);
				}
				return appApi(0,$resdb['msg']);				
		    }
			return appApi(0,'应用不存在');						
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
        return appApi(0,'数据错误');
    }

    /**
     * @title 取用户应用信息(验证/激活-令牌操作)
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/getuserapp
     * @method GET
     *
     * @param name:token type:string require:1 default:1 other: desc:用户令牌
     * @param name:device_code type:string require:1 default:null other: desc:设备码

	 * 
     * @return expire_time/points:应用到期时间/剩余点数
     * @return connect_time:应用连接时间
     * @return connect_ip:应用链接IP
	 * @return connect_count:应用连接次数
	 * @return comment:备注
	 * @return user_data:应用用户数据
	 * @return consts:应用常量(须授权常量和公开常量在此显示,json类型)
	 * @return variables:变量(应用变量,可提交,json类型)
     */
    public function getUserApp(Request $request){
    	if($request->isGet()){
    	 	$inputs=input('param.');
			$validate = Validate::make(               
                [
                'app_id'    => 'require|integer',
                'token'     => 'require',
                'device_code' => 'require',
                ],
                [
                'app_id'       => '应用ID不能为空',
                'token'        => '令牌不能为空',
                'device_code'  => '设备码不能为空',
                ]
			);
            if (!$validate->check($inputs)) {
            	return appApi(0,$validate->getError());               
            }
			$usertoken = new UserToken();

            $tokendb = $usertoken
            ->where('token',$inputs['token'])
			->where('expire_time','>',App::getBeginTime())
            ->find();			
			if($tokendb){
				$tokendb['bind_device_code'] = $inputs['device_code'];
				$tokendb['connetc_ip'] = $request->ip();			
				$appsuser = new AppsUser();
				$resdb = $appsuser->getAppUser($tokendb);
				if($resdb['code'] == 1){
					$datas = $this->enBaseAuth($resdb['data'],$this->app_crypt);
					return appApi(1,$resdb['msg'],$datas);
				}
				return appApi(0,$resdb['msg']);			
			}
			return appApi(0,'令牌过期或不存在,请重新获取');
			
    	}
        return appApi(0,'数据错误');				
    }
    /**
     * @title 设置变量(设置用户变量-令牌操作)
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/setuservariable
     * @method GET
     *
     * @param name:token type:string require:1 default:1 other: desc:用户令牌
     * @param name:variable type:string require:1 default:null other: desc:变量名
	 * @param name:value type:string require:1 default:null other: desc:变量值
	 * 
     * @return variable:变量名
	 * @return value:新变量值
     */
	public function setUserVariable(Request $request){
		if($request->isGet()){
			$inputs=input('param.');
			$validate = Validate::make(
                
                [
                    'app_id'    => 'require|integer',
                    'token'     => 'require',
                    'variable' => 'require',
                ],
                [
                    'app_id'       => '应用ID不能为空',
                    'token'        => '令牌不能为空',
                    'variable'        => '变量名不能为空',
                ]
			);
            if (!$validate->check($inputs)) {
            	return appApi(0,$validate->getError());               
            }
			$usertoken = new UserToken();
            $tokendb = $usertoken
            ->where('token',$inputs['token'])
			->where('app_id',$inputs['app_id'])
			->where('expire_time','>',App::getBeginTime())
            ->find();
			if($tokendb){
				$tokendb['connetc_ip'] = $request->ip();
				$tokendb['variable']   = $inputs['variable'];
				$tokendb['value']  = $inputs['value'];
				$appvar = AppsVar::get(['app_id'=>$inputs['app_id'],'variable'=>$tokendb['variable']]);
				if(empty($appvar)){
					return appApi(0,'该应用变量不存在');	
				}				
			    $user_var = AppsUserVar::get(['user_id'=>$tokendb['user_id'],'variable_id'=>$appvar['id']]);
				$datas = ['variable'=>$tokendb['variable'],'value'=>$tokendb['value']];
				$datas = $this->enBaseAuth($datas,$this->app_crypt);
				if($user_var){
					$user_var->value = $tokendb['value'];
					$user_var->save();
					
					return appApi(1,'变量更新成功',$datas);
				}
				$classdb = new AppsUserVar();
				$classdb->variable_id = $appvar['id'];
				$classdb->user_id = $tokendb['user_id'];
				$classdb->value = $tokendb['value'];
				$classdb->save();
				return appApi(1,'变量更新成功',$datas);
				
				
			}
			return appApi(0,'令牌过期或不存在,请重新获取');							
		}
		return appApi(0,'数据错误');
	}
    /**
     * @title 用户扣点(用户扣点-令牌操作)
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/setuserdec
     * @method GET
     *
     * @param name:token type:string require:1 default:1 other: desc:用户令牌
     * @param name:points type:string require:1 default:null other: desc:扣除的点数/零为默认扣点
	 * 
     * @return dec_points:扣除点数
     */
	public function setuserdec(Request $request){
		if($request->isGet()){
			$inputs=input('param.');
			$validate = Validate::make(
                
                [
                    'app_id'    => 'require|integer',
                    'token'     => 'require',
                ],
                [
                    'app_id'       => '应用ID不能为空',
                    'token'        => '令牌不能为空',
                ]
			);
            if (!$validate->check($inputs)) {
            	return appApi(0,$validate->getError());               
            }
			$usertoken = new UserToken();
            $tokendb = $usertoken
            ->where('token',$inputs['token'])
			->where('app_id',$inputs['app_id'])
			->where('expire_time','>',App::getBeginTime())
            ->find();
			if($tokendb){
				$apps = Apps::get($inputs['app_id']);
				$tokendb['points'] = $apps['dec_points'];
				if($inputs['points']){
					$tokendb['points']   = $inputs['points'];
				}
				$where=['app_id'=>$inputs['app_id'],'user_id'=>$tokendb['user_id']];
				$app_user = AppsUser::get($where);
				if($app_user['points'] < $tokendb['points']){
					return appApi(0,'用户点数不足');
				}
				
			    AppsUser::where($where)->setDec('points',$tokendb['points']);

                $datas = ['dec_points'=>$tokendb['points']];
				$datas = $this->enBaseAuth($datas,$this->app_crypt);
				return appApi(1,'扣点成功',$datas);				
				
			}
			return appApi(0,'令牌过期或不存在,请重新获取');
		}
        return appApi(0,'数据错误');
					
	}
    /**
     * @title 用户注册
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/userregister
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     * @param name:username type:string require:1 default:null other: desc:用户名
	 * @param name:password type:string require:1 default:null other: desc:密码
	 * @param name:enpassword type:string require:1 default:null other: desc:确认密码
	 * 
     * @return username:用户名
	 * @return password:密码
     */
	public function userRegister(Request $request){
		if($request->isGet()){
			$indata=input('param.');
			$indata['create_ip']  = $request->ip();
			$validate = Validate::make(
                
                [
                'app_id'     => 'require|integer',
                'secret_key' => 'require',
                'username'   => 'require|length:3,25|chsAlphaNum',
                'password'   => 'require|min:5',
                'enpassword' => 'require|min:5|confirm:password',
                ],
                [
                'app_id'           => '应用ID不能为空',
                'secret_key'       => 'secret key 不能为空', 
                'username'         => '用户名必须是汉字,字母或数字',
                'password'         => '密码至少5位以上字符',
                'enpassword'       => '确认密码至少5位以上字符,并与密码相同',
                ]
			);
            if (!$validate->check($indata)) {
            	return appApi(0,$validate->getError());               
            }
			
			$register = new Users();
			$rest = $register -> inRegister($indata);
			if($rest['code'] == 1){
				$datas = $this->enBaseAuth($rest['data'],$this->app_crypt);
				return appApi(1,$rest['msg'],$datas);
			}
			return appApi(0,$rest['msg']);
			
			
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		return appApi(0,'数据错误');
		
	}
    /**
     * @title 充值卡充值
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/userrecharge
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     * @param name:username type:string require:1 default:null other: desc:用户名
	 * @param name:card_number type:string require:1 default:null other: desc:充值卡号
	 * 
     * @return username:用户名
	 * @return surplus_value:剩余数值(到期时间/点数/永久)
     */
	public function userRecharge(Request $request){//卡充值未开放
		if($request->isGet()){
			$indata=input('param.');
			$indata['client_ip']  = $request->ip();
			//$indata['create_user_id'] = $this->create_user_id;
			
			$validate = Validate::make(
                
                [
                'app_id'      => 'require|integer',
                'secret_key'  => 'require',
                'username'    => 'require|length:3,25|chsAlphaNum',
                'card_number' => 'require',
                ],
                [
                'app_id'       => '应用ID不能为空',
                'secret_key'   => 'secret key 不能为空', 
                'username'     => '用户名必须是汉字,字母或数字',
                'card_number'  => '卡号不能为空',
                ]
			);
            if (!$validate->check($indata)) {
            	return appApi(0,$validate->getError());               
            }
			
			$appsuser = new AppsUser();
			$rest = $appsuser -> userRecharge($indata);
			if($rest['code'] == 1){
				$datas = $this->enBaseAuth($rest['data'],$this->app_crypt);
				return appApi(1,$rest['msg'],$datas);
			}
			return appApi(0,$rest['msg']);
		
		}
		return appApi(0,'数据错误');
		
	}
    /**
     * @title 用户应用解绑
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/userunbind
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     * @param name:username type:string require:1 default:null other: desc:用户名
	 * @param name:password type:string require:1 default:null other: desc:密码
	 * 
     * @return dec_time:解绑扣时间值
	 * @return dec_score:解绑扣积分值
	 * @return points:解绑扣除点数
     */
    public function userUnbind(Request $request){
		if($request->isGet()){
			$indata=input('param.');
			$indata['client_ip']  = $request->ip();
			//$indata['create_user_id'] = $this->create_user_id;
			
			$validate = Validate::make(
                
                [
                'app_id'     => 'require|integer',
                'secret_key' => 'require',
                'username'   => 'require|length:3,25|chsAlphaNum',
                'password'   => 'require|min:5',
                ],
                [
                'app_id'       => restApi(20001,'应用ID不能为空'),
                'secret_key'   => restApi(20002,'secret key 不能为空'), 
                'username'     => restApi(70001,'用户名必须是汉字,字母或数字'),
                'password'         => restApi(70003,'密码至少5位以上字符'),
                ]
			);
            if (!$validate->check($indata)) {
            	return appApi(0,$validate->getError());               
            }
			
			$appsuser = new AppsUser();
			$rest = $appsuser -> userUnbind($indata);
			if($rest['code'] == 1){
				$datas = $this->enBaseAuth($rest['data'],$this->app_crypt);
				return appApi(1,$rest['msg'],$datas);
			}
			return appApi(0,$rest['msg']);	
		}
		return jsonApi(20000,'提交方法错误');				
	}
    /**
     * @title 用户修改密码
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_user_api/usereditpassword
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     * @param name:username type:string require:1 default:null other: desc:用户名
	 * @param name:oldpassword type:string require:1 default:null other: desc:原密码
	 * @param name:password type:string require:1 default:null other: desc:新密码
	 * @param name:enpassword type:string require:1 default:null other: desc:确认新密码
	 * 
     * @return id:用户id
	 * @return username:用户名
     */

    public function userEditPassword(Request $request){
    	if($request->isGet()){
			$indata=input('param.');
			$indata['create_ip']  = $request->ip();
			$validate = Validate::make(
                
                [
                'app_id'     => 'require|integer',
                'secret_key' => 'require',
                'username'   => 'require|length:3,25|chsAlphaNum',
                'oldpassword'=> 'require|min:5',
                'password'   => 'require|min:5',
                'enpassword' => 'require|min:5|confirm:password',
                ],
                [
                'app_id'           => '应用ID不能为空',
                'secret_key'       => 'secret key 不能为空', 
                'username'         => '用户名必须是汉字,字母或数字',
                'oldpassword'      => '旧密码至少5位以上字线或数字',
                'password'         => '新密码至少5位以上字线或数字',
                'enpassword'       => '确认密码至少5位以上字线或数字,并与密码相同',
                ]
			);
            if (!$validate->check($indata)) {
            	return appApi(0,$validate->getError());               
            }			
			$user = new Users();
			$rest = $user -> inEditPassword($indata);
			if($rest['code'] == 1){
				$datas = $this->enBaseAuth($rest['data'],$this->app_crypt);
				return appApi(1,$rest['msg'],$datas);
			}
			return appApi(0,$rest['msg']);
		}
		return appApi(0,'数据错误');
    } 	
	protected function deBaseAuth($string,$crypt = null){
		if($crypt == 'not' || $crypt == null){
			return $string;
		}		
		$key=$this->developer_key;
		return baseAuth($string, $operation = 'DECODE', $key);
	}
	protected function enBaseAuth($string,$crypt = null){
		if($crypt == 'not' || $crypt == null){
			return $string;
		}
		$key=$this->developer_key;
		return baseAuth(json_encode($string,JSON_UNESCAPED_UNICODE), $operation = 'ENCODE', $key , $expiry=0);
	}
	
	protected function getDeve($user_id){
		$devedb = AppsDeve::get(['user_id'=>$user_id]);
		$devedb = $devedb->getData();
		if($devedb){
			return $devedb;
		}
		return FALSE;
	}
	protected function getApps($app_id){
		$appdb   = Apps::get(['id'=>$app_id]);
		
		if($appdb){
			$appdb = $appdb->getData();
			return $appdb;
		}
		return FALSE;
	}

}
