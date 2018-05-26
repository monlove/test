<?php
namespace app\common\controller;

use think\Db;
use Config;
use Request;
use think\facade\Env;

class Common
{
    public function getModuleMenu($module='',$status=1){
    	$where=['module'=>$module,'status'=>$status];
    	$meundb=db('menu')->where($where)->select();
		return $meundb;
    	
    }	
    public function getPositionMenu($position='',$status=1){
    	$where=['position'=>$position,'status'=>$status];
    	$meundb=db('menu')->where($where)->select();
		return $meundb;
    	
    }


	public function getNodeMenu($node='',$status=1){
    	$where=['node'=>$node,'status'=>$status];
    	$meundb=db('menu')->where($where)->select();
		return $meundb;
    	
    }
	public function getParentMenu($Parent=0,$status=1){
    	$where=['arent'=>$Parent,'status'=>$status];
    	$meundb=db('menu')->where($where)->select();
		return $meundb;
    	
    }	
    
	public function getActionDb($node){
    	$where=['node'=>$node];
    	$resdb=db('menu')->where($where)->max('parent_id');
		$resdb=db('menu')->where($where)->where('parent_id',$resdb)->find();
		return $resdb;
    	
    }
	public function getParentDb($parent_id){
    	$where=['id'=>['id','in',$parent_id]];
		$resdb=db('menu')->where($where)->find();
		return $resdb;
    	
    }
	
	public function getAuthFile(){
		$request = Request::instance();
		$domain = get_domain($request->domain());
		$file = Env::get('root_path').'runtime/'.md5($domain).'.key';
		if (!file_exists($file)){
			$data = ['site_app_id'=>1,'domain'=> $domain];
		    $crypt_data = rain_encrypt(json_encode($data),Config::get('rainos.rain_key'));
		    $res = chttp(Config::get('rainos.auth_url'),['auth'=>$crypt_data]);
			file_put_contents($file,$res);
		}else{
			$filetime = filectime($file);
			$exist_time = time()-$filetime;
			//dump($exist_time);
			if(604800 < $exist_time){
				return $this->resteAuthFile();
			}

		}
		$str = file_get_contents($file);		
		$rest = rain_decrypt($str,Config::get('rainos.rain_key'));
		$rest_db = json_decode($rest,TRUE);					    
		return $rest_db;
	}
	
	public function resteAuthFile(){
		$request = Request::instance();
		$domain = get_domain($request->domain());
		$file = Env::get('root_path').'runtime/'.md5($domain).'.key';
         
		$data = ['site_app_id'=>1,'domain'=> $domain];
		$crypt_data = rain_encrypt(json_encode($data),Config::get('rainos.rain_key'));
		$res = chttp(Config::get('rainos.auth_url'),['auth'=>$crypt_data]);
		file_put_contents($file,$res);

		$str = file_get_contents($file);		
		$rest = rain_decrypt($str,Config::get('rainos.rain_key'));
		$rest_db = json_decode($rest,TRUE);					    
		return $rest_db;		
	}
}
