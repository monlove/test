<?php

namespace app\app\logic;

use think\Controller;
use think\Request;
use think\helper\Hash;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsConsts;
use app\app\model\AppsUserToken as UserToken;
use app\app\model\AppsDeveloper as AppsDeve;
use App;

class AppsApi extends Controller
{
	/**
     * 开发者密钥
     * @var $developer_key
     */	
	protected $developer_key;
	
	/**
     * 构造	
     * 
     */			
	public function __construct(Request $request)
    {
        if(input('?get.app_id') && input('param.app_id')){
        	$appdb = $this->getApps(input('param.app_id'));
			if($appdb){
				$devedb = $this->getDeve($appdb['create_user_id']);
			}
			$this->developer_key = $devedb['developer_key'];
			
        }	
        
    }
	
    /**
    * @title 调试加密
    *
    * @param app_id 应用ID
    * @param db 是 string 调试的名文
    * @return  返回加密后的数据
    * @example 调用示例
    * @method POST http://www.rain68.com/appapi/index
    * @author Rain <80692285@qq.com>
    */
    public function index(Request $request)
    {
        	
        //echo timeTodate(1499073558);
        return $this->enBaseAuth(input('param.db'));
    }

    /**
    * @title 取应用信息
    *
    * @param app_id 应用ID
    * @param secret_key 应用密钥
    * @return  {"code":返回码,"msg":"信息","content":"返加内容","data":{"id":应用ID,"name":"应用名","display_name":"显示名","create_user_id":"开发者","create_time":"应用创建时间","tryout_time":可试用时间,"update_time":"更新时间","version":"版本号","down_url":"下载URL","icon":"应用图标路径","comment":"备注","announcement":"公告","bind_ip":"绑定IP开关","bind_device_code":"绑定设备开关","unbind_dec_time":解绑扣时,"unbind_dec_score":"解绑扣积分","unbind_count":解绑次数,"status":应用状态,"const":应用自定议数据json格式}}
    * @example http://www.rain68.com/appapi/getapp?app_id=1&secret_key=应用secret_key[authcode加密后用base64编码]
    * @method GET http://www.rain68.com/appapi/getapp
    * @author Rain <80692285@qq.com>
    */	
    public function getApp(Request $request)
    {
        if($request->isGet()){
        	$inputs=input('param.');
			$result = $this->validate(
                $inputs,
                [
                'app_id'         => 'require|integer',
                'secret_key'   => 'require',                
                ],
                [
                'app_id'         => '应用ID不能为空',
                'secret_key'   => 'secret key 不能为空',                
                ]
			);
            if(true !== $result){
                return json_encode($result);
            }
        }	
        $appdb   = new Apps();
        $restapp = $appdb->where('id', $inputs['app_id'])
	    ->where('secret_key', $this->deBaseAuth($inputs['secret_key']))
		->field('create_user,secret_key',true)
        ->find();
	    if($restapp){
			if($restapp['status'] < 1){
				return jsonApi(20003,'应用已停用');
			}
			$const = new AppsConsts();
			$constdb = $const->where('app_id',$inputs['app_id'])
			->where('auth_status','off')
			->field('app_id,create_time,update_time,status',true)
			->find();
			$restapp['const'] = $constdb;
			return jsonApi(1,'取应用信息成功',$restapp->toArray());
		}
		return jsonApi(20004,'应用不存在');
    }
    /**
    * @title 取应用信息
    *
    * @param app_id 应用ID
    * @param secret_key 应用密钥
    * @return  {"code":返回码,"msg":"信息","content":"返加内容","data":{"id":应用ID,"name":"应用名","display_name":"显示名","create_user_id":"开发者","create_time":"应用创建时间","tryout_time":可试用时间,"update_time":"更新时间","version":"版本号","down_url":"下载URL","icon":"应用图标路径","comment":"备注","announcement":"公告","bind_ip":"绑定IP开关","bind_device_code":"绑定设备开关","unbind_dec_time":解绑扣时,"unbind_dec_score":"解绑扣积分","unbind_count":解绑次数,"status":应用状态,"const":应用自定议数据json格式}}
    * @example http://www.rain68.com/appapi/getapp?app_id=1&secret_key=应用secret_key[authcode加密后用base64编码]
    * @method GET http://www.rain68.com/appapi/getapp
    * @author Rain <80692285@qq.com>
    */
	public function getUserToken(Request $request){		
        if($request->isGet()){
			$inputs=input('param.');
			$result = $this->validate(
                $inputs,
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
            if(true !== $result){
                 // 验证失败 输出错误信息
                return json_encode($result);
            }
												
			$appdb   = new Apps();
            $restapp = $appdb->where('id', $inputs['app_id'])
	        ->where('secret_key', $this->deBaseAuth($inputs['secret_key']))
		    ->field('create_user,secret_key',true)
            ->find();
	        if($restapp){
			    if($restapp['status'] < 1){
				    return jsonApi(20005,'应用已停用');
			    }
				$inputs['password'] = $this->deBaseAuth($inputs['password']);
	            $tokendb = new UserToken();
				$resdb = $tokendb->getToken($inputs);
				if($resdb['code'] == 1){
					return json_encode($resdb);
				}
				return json_encode($resdb);				
		    }
		    return jsonApi(20006,'应用不存在');						
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		return jsonApi(20000,'数据错误');
    }

    public function getUserApp(Request $request){
    	if($request->isGet()){
    	 	$inputs=input('param.');
			$result = $this->validate(
                $inputs,
                [
                'app_id'    => 'require|integer',
                'token'     => 'require',
                'device_code' => 'require',
                ],
                [
                'app_id'       => '应用ID不能为空',
                'token'       => '令牌不能为空',
                'device_code' => '设备码不能为空',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                return json_encode($result);
            }
			$usertoken = new UserToken();
              // 查询单个数据
            $tokendb = $usertoken
            ->where('token',$this->deBaseAuth($inputs['token']))
			->where('expire_time','>',App::getBeginTime())
            ->find();			
			if($tokendb){
				$tokendb['bind_device_code'] = $this->deBaseAuth($inputs['device_code']);
				$tokendb['connetc_ip'] = $request->ip();			
				$appsuser = new AppsUser();
				$resappuser = $appsuser->getAppUser($tokendb);
				return $resappuser;				
			}
			return jsonApi(20034,'令牌过期或不存在,请重新获取');
			
    	}
		return jsonApi(20000,'数据错误');				
    }
	
		
	protected function deBaseAuth($string){
		$key=$this->developer_key;
		return baseAuth($string, $operation = 'DECODE', $key);
	}
	protected function enBaseAuth($string){
		$key=$this->developer_key;
		return baseAuth($string, $operation = 'ENCODE', $key , $expiry=0);
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
		$appdb = $appdb->getData();
		if($appdb){
			return $appdb;
		}
		return FALSE;
	}

}
