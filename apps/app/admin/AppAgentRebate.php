<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentRebate as Rebates;
use Request;
use think\Db;
use Config;

class AppAgentRebate extends Base
{
    /**
     * @node 返利记录
	 * 
     *
     */		
    public function index()
    {    	
        return $this->fetch();
    }
		
    /**
     * @node 返利记录列表
	 * 
     *
     */		
	public function lists()
	{		
		$draw    = input('param.draw');			
		$start   = input('param.start');	
		$length  = input('param.length');
		$search  = input('param.search/a');
		$order   = input('param.order/a');
		$columns = input('param.columns/a');
		$action  = input('param.action');
 		       
        $user_id = Users::where('username','like', ['%'.$search['value'].'%'])->column('id');
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
		if($search['value']){
			$count = Rebates::hasWhere('user',['username'=>$search['value']])->count();
			$model_class = Rebates::hasWhere('user',['username'=>$search['value']])->select();
		}else{
			$count = Rebates::count();			
		    $model_class  = Rebates::order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		}
		$model_list = $model_class->toArray();
		
		foreach ($model_list as $key => $val) {
			$user_db = Users::get($model_list[$key]['user_id']);
			$trade_user_db = Users::get($model_list[$key]['trade_user_id']);
			$model_list[$key]['username'] = $user_db['username'];
			$model_list[$key]['trade_user'] = $trade_user_db['username'];



		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$model_list];
	}
	
  
}
