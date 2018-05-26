<?php
namespace app\app\behavior;

use Request;
use app\app\model\AppsDeveloper as AppsDeve;
use app\app\model\Apps;

class Api 
{	
	/*
	 * @name Api接口行为
	 * 
	 */   
    public function run(&$params)
    {
        $request    = Request::instance();
		$module     = $request->module();
		$controller = $request->controller();
		$param      = $request->param();
//		echo '<pre>';
//		var_dump($request);
//		if($param['app_id']){
//			$appdb = $this->getApps(input('param.app_id'));
//			if($appdb){
//				$devedb = $this->getDeve($appdb['create_user_id']);
//			}
//			$create_user_id = $appdb['create_user_id'];
//		}
		
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