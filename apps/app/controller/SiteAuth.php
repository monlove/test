<?php
namespace app\app\controller;

use think\Controller;
use app\app\model\SiteAppsAuthorize as Authorize;
use app\app\model\SiteApps;
use app\user\model\Users;
use Request;
use Config;

/**
 * @title 应用接口
 * @description 接口说明
 * @param name:app_id type:int require:1 default:1 other: desc:应用ID
 */
class SiteAuth extends Controller
{
	/**
     * @node 取授权
	 * 
     *
     */
    public function index(){
        if(Request::instance()->isGet()){
            $params = input('param.auth');
            $site_key = Config::get('rainos.rain_key');
			$rest_key = rain_decrypt($params,$site_key);
            $rest     = json_decode($rest_key);
			//$rests_key = rain_decrypt($rest_key, $site_key['value']);
			
			$restdb = Authorize::where('site_app_id',$rest->site_app_id)->where('domain','like','%'.$rest->domain.'%')->find();
			$rest_type = $restdb->getData('author_type');
			if($restdb){
				$restdb = $restdb->toArray();
				$resdata =[
				    'user_id'     => $restdb['user_id'],
				    'site_app_id' => $restdb['site_app_id'],
				    'author_type' => $restdb['author_type_text'],
				    'author_data' => $restdb['author_type'],
				    'types'       => $rest_type,
				    'domain'      => $restdb['domain'],
				    'server_expire_time'      => $restdb['server_expire_time'],
				];
				return rain_encrypt(json_encode($resdata,JSON_UNESCAPED_UNICODE), $site_key);
			}
			$resdata =[
				'user_id'     => 1,
				'site_app_id' => $rest->site_app_id,
		        'author_type' => 'free',
		        'domain'      => $rest->domain,
			];
			 
           return rain_encrypt(json_encode($resdata,JSON_UNESCAPED_UNICODE), $site_key);
        }
         $resdata = ['author_type'=>'error'];
		return rain_encrypt(json_encode($resdata,JSON_UNESCAPED_UNICODE), $site_key);    	
    }
}
