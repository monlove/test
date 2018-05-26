<?php

namespace app\app\logic;

use think\Controller;
use Request;
use Config;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentUser as AgentUser;
use app\app\model\AppsAgentSort as AgentSort;
use app\app\model\AppsPrice as Price;
use app\app\model\AppsAgentRebate as Rebate;
use app\app\model\TradeRecord as Record;
use App;

class UserApp extends Controller
{
    //用户加时加点
    public function userAppInc($user_id,$price_id){    			
    	$price_db = Price::get($price_id);
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
	
		//dump(config('unit.hour')['time']);exit;
		if($price_db['unit'] == 'points'){
			AppsUser::where(['user_id'=>$user_id,'app_id'=>$price_db['app_id']])->setInc('points',$price_db['unit_num']);			
		}
		if($price_db['unit'] == 'unlimited'){
			AppsUser::where(['user_id'=>$user_id,'app_id'=>$price_db['app_id']])->update(['unlimited_status'=>'on']);
		}
		if($price_db['unit'] != 'points' && $price_db['unit'] != 'unlimited'){
			$ste_inc = config('unit.'.$price_db['unit'])['time'] * $price_db['unit_num'];
			$app_user = AppsUser::get(['user_id'=>$user_id,'app_id'=>$price_db['app_id']]);
			
			if($app_user['expire_time'] > App::getBeginTime() ){
				AppsUser::where(['user_id'=>$user_id,'app_id'=>$price_db['app_id']])->setInc('expire_time',$ste_inc);
			}else{
				AppsUser::where(['user_id'=>$user_id,'app_id'=>$price_db['app_id']])->update(['expire_time' => App::getBeginTime()+$ste_inc]);
			}
			
		}
		    	
    }
    //代理返利
    public function agentRebate($trade_record){
    	$record = Record::get($trade_record);//取出订单
		$agent_user = AgentUser::get(['user_id'=>$record['user_id']]);//取用户的代理
		if($agent_user){
			$agent = Agents::get(['user_id'=>$agent_user['agent_user_id']]);
			$agent_sort = AgentSort::get($agent['sort_id']);
			$rebate_money = $record['total_fee'] * $agent_sort['rebate_ratio'];//取得返利金额
			Rebate::create([
			    'user_id'         => $agent_user['agent_user_id'],
			    'trade_user_id'   => $record['user_id'],
			    'trade_record_id' => $record['user_id'],
			    'rebate'          => $rebate_money,
			    'centent'         => $record['body'],
			
			]);
			Agents::where('id',$agent['id'])->setInc('rebate',$rebate_money);
			
        }
		
    	
    } 

}
