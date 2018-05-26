<?php
namespace app\common\behavior;

use Request;
use app\page\model\PagesTheme;
use think\Controller;
use Cookie;
use app\user\model\Users;

class TnCookie
{
	/*
	 * @name 动态配置
	 * 
	 */   
    public function run(Request $request, $params)
    {
		$params = input('param.');
		if(!Cookie::has('agent_tn') && isset($params['tn'])){
			$user_tn = Users::get(['username'=>$params['tn']]);
			if($user_tn){
				Cookie::set('agent_tn',$params['tn'],3600);
			}
			
		}
		//Cookie::delete('agent_tn');	
		//echo Cookie::get('agent_tn');exit;
		
    }

}
