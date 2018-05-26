<?php

namespace app\app\controller;

use think\Controller;
use think\Request;
use think\helper\Hash;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsConsts;
use app\app\model\AppsUserToken as UserToken;
use Config;
use App;
use Validate;

/**
 * @title 应用接口
 * @description 接口说明
 * @param name:app_id type:int require:1 default:1 other: desc:应用ID
 */
class AppApi extends Controller
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
				//$devedb = $this->getDeve($appdb['create_user_id']);
			}
			$this->developer_key = config('site.site_key');
			//dump($this->developer_key);exit;
			
        }
		//dump(config('site_key'));exit;	
        
    }

    public function index(Request $request)
    {
        	
        //echo timeTodate(1499073558);
        return $this->enBaseAuth(input('param.db'));
    }


    /**
     * @title 取应用信息
     * @description 接口说明:成功后如后台设置应用加密,返回的data数据将被加密
     * @author 开发者
     * @url /app_api/getapp
     * @method GET
     *
     * @param name:secret_key type:string require:1 default:1 other: desc:应用密钥
     *
     * @return app_id:应用ID
     * @return name:应用名称
     * @return display_name:显示名称
	 * @return crypt:data数据是否加密
	 * @return create_time:应用创建时间
	 * @return tryout_time:试用时间
	 * @return update_time:更新时间
	 * @return version:版本号
	 * @return down_url:下载地址
	 * @return icon:应用图标地址
	 * @return tryout_points:试用点数
	 * @return comment:应用说明
	 * @return announcement:应用公告 
	 * @return bind_ip:是否绑定IP 
	 * @return bind_device_code:是否绑定硬件 
	 * @return unbind_dec_time:解绑扣时 
	 * @return unbind_dec_points:解绑扣点 
	 * @return unbind_dec_score:解绑扣分 
	 * @return unbind_count:解绑次数 
	 * @return status:应用状态 
	 * @return const:应用公开常量(json)
	 * @return unbind_count:解绑次数 
	 * @return unbind_count:解绑次数 
	 * @return setver_time:服务器时间 
     */	
    public function getApp(Request $request)
    {
        
        if($request->isGet()){
        	$inputs=input('param.');
			$validate = Validate::make(
			[
                'app_id'      => 'require|integer',
                'secret_key'  => 'require',
            ],
            [
                'app_id'      => '应用ID不能为空',
                'secret_key'  => 'secret key 不能为空',                
                ]
			);

            if (!$validate->check($inputs)) {
            	return appApi(0,$validate->getError());               
            }

			$appdb   = new Apps();
            $restapp = $appdb->where('id', $inputs['app_id'])
	        ->where('secret_key', $inputs['secret_key'])
		    ->field('create_user_id,secret_key',true)
            ->find();
	        if($restapp){
			    if($restapp['status'] < 1){
					return appApi(0,'应用已停用');
			    }
			    $const = new AppsConsts();
			    $constdb = $const->where('app_id',$inputs['app_id'])
			    ->where('auth_status','off')
			    ->field('app_id,create_time,update_time,status',true)
			    ->select();
			    $restapp['const'] = $constdb;
				$restapp['server_time'] =  App::getBeginTime();
				$data = $restapp->toArray();
				$datas = $this->enBaseAuth($data,$data['crypt']);				
			    return appApi(1,'取应用信息成功',$datas);
		    }
		    return appApi(0,'应用不存在');
        }	        
		return appApi(0,'数据有误');
    }
    
	
		
	protected function deBaseAuth($string,$crypt = null){
		if($crypt == 'not' || $crypt == null){
			return $string;
		}
		$key=$this->developer_key;
		return $crypt($string, $operation = 'DECODE', $key);
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
		
		if($devedb){
			return $devedb;
		}
		return FALSE;
	}
	protected function getApps($app_id){
		$appdb   = Apps::get(['id'=>$app_id]);
		
		if($appdb){
			return $appdb;
		}
		return FALSE;
	}
	

}
