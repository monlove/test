<?php
namespace app\admin\controller;

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

    public function index(){
    	
    	$params = $this->getAuthData();		
		$confile = APP_PATH.md5($params['domain']).'.key';		
		if(!file_exists($confile)){
			return ['code'=>0 ,'author_type'=>'not'];
        }
		$str = file_get_contents($confile);		
		$rest = rain_decrypt($str,Config::get('rainos.rain_key'));
		$rest_db = json_decode($rest,TRUE);

		if($params['domain'] == $rest_db['domain']){
			return ['code'=>1 ,'author_type'=>$rest_db['author_type']];
		}
		return ['code'=>0 ,'author_type'=>'not'];

    }
	protected function getAuthData(){
    	$request = Request::instance();
		$domain = $request->domain();
	    $data = ['site_app_id'=>1,'domain'=> get_domain($request->domain())];
		return $data;
	}
	

}
