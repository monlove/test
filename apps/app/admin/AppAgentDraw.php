<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentSort as Sorts;
use app\app\model\AppsAgentDraw as AgentDraw;
use Request;
use think\Db;
use Config;

class AppAgentDraw extends Base
{
    /**
     * @node 提现记录
	 * 
     *
     */		
    public function index()
    {

    	        	
        return $this->fetch();
    }
	
	
    /**
     * @node 代理列表
	 * 
     *
     */		
	public function lists()
	{		
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');
        
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
		
		if($search['value']){
			$count = AgentDraw::hasWhere('user',['username'=>$search['value']])->count();
			$draw_list = AgentDraw::hasWhere('user',['username'=>$search['value']])->select();
		}else{
			$count = AgentDraw::count();			
		    $draw_list  = AgentDraw::order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		}	
		//dump(implode(',',$user_id));
		
		$draw_list = $draw_list->toArray();
		foreach ($draw_list as $key => $val) {
			$user_db = Users::get($draw_list[$key]['user_id']);			
			$draw_list[$key]['username'] = $user_db['username'];

		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$draw_list];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function draw()
    {       	
        $agent_db = Agents::get(input('param.id'));
		$agent_db['user_db'] = Users::get($agent_db['user_id']);
		$this->assign('agent_db',$agent_db);
		
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inDraw(){		
		if(Request::instance()->isPost()){
			
			$update=input('post.');
			//return $update;
			$result = $this->validate(
                $update,
                [
                'money'         => 'float',
                'poundage'      => 'float',          
                ],
                [
                'money'        =>'提现金额必需为小数 ',
                'poundage'     =>'手续费必需为小数 ',          
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
            $rest_agent = Agents::get($update['agent_id']);
			if($rest_agent['rebate'] < $update['money']){
				$this->error('提现金额超出余额');
			}
            if($update['money'] < $update['poundage']){
            	$this->error('手续费超出提现余额');
            }			
            $rest_agent ->setDec('rebate',$update['money']);
			$rest_agent->save();
            AgentDraw::create([
                'user_id'=> $rest_agent['user_id'],
				'money'  => $update['money'],
				'poundage'  => $update['poundage'],
				'actual_amount'  => $update['money']-$update['poundage'],
				
			]);
			$this->success('提现成功');
		}				
	}
	  
}
