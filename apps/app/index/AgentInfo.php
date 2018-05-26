<?php
namespace app\app\index;

use app\index\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent;
use app\app\model\AppsAgentDraw as Draw;
use app\app\model\AppsAgentRebate as Rebate;
use app\app\model\AppsAgentSort as Sort;
use app\app\model\AppsAgentUser as AgentUser;
use Request;
use Session;
use Cookie;

//代理商信息
class AgentInfo extends Base
{
    public function index()
    {
        $user_id = is_login();
		if($user_id){
			$request = Request::instance();
			$domains = $request->domain();
			
            $app_agent = AppsAgent::get(['user_id'=>$user_id]);
			$app_agent['sort']       = Sort::get($app_agent['sort_id']);//代理商类型
			$app_agent['draw_sum']   = Draw::where('user_id',$user_id)->sum('money');//代理提现总计
			$app_agent['rebate_count']     = Rebate::where('user_id',$user_id)->count();//代理返利次数
			
			
			$app_agent['user_count'] = AgentUser::where('agent_user_id',$user_id)->count();//代理用户数
			$user_list     = AgentUser::where('agent_user_id',$user_id)->order('id desc')->limit(20)->select();
			foreach($user_list as $ku=>$vu){
				$user_list[$ku]['user_info'] = Users::get($user_list[$ku]['user_id']);
			}
			$app_agent['users'] = $user_list;
			
			$this->assign('domains',$domains);
            $this->assign('app_agent',$app_agent);
            return $this->fetch();			
		}	
        $this->redirect('index/User/login');
    }
	
	public function userLists(){
        $user_id = is_login();
		if(!$user_id){
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>[]];			
		}		
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');
		$sub_user_id = Users::where('username','like', ['%'.$search['value'].'%'])->column('id');
		
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'create_time';
		    $order[0]['dir'] = 'desc';
		}
		//var_dump($order_name);		
		$classdb = new AgentUser();
		$count = $classdb->where('agent_user_id',$user_id)->where('user_id','in',implode(',',$sub_user_id)) ->count();			
		$user  = $classdb->where('agent_user_id',$user_id)->where('user_id','in',implode(',',$sub_user_id))->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$userlist = $user->toArray();
		foreach($userlist as $key=>$val){
			$sub_user_info = Users::get($userlist[$key]['user_id']);
			$userlist[$key]['username'] = $sub_user_info['username'];
		}

		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$userlist];		
	}

	public function rebateLists(){
        $user_id = is_login();
		if(!$user_id){
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>[]];			
		}		
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');
		$sub_user_id = Users::where('username','like', ['%'.$search['value'].'%'])->column('id');
		
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'create_time';
		    $order[0]['dir'] = 'desc';
		}
		//var_dump($order_name);		
		$classdb = new Rebate();
		$count = $classdb->where('user_id',$user_id)->where('trade_user_id','in',implode(',',$sub_user_id)) ->count();			
		$rebate  = $classdb->where('user_id',$user_id)->where('trade_user_id','in',implode(',',$sub_user_id))->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$rebatelist = $rebate->toArray();
		foreach($rebatelist as $key=>$val){
			$sub_user_info = Users::get($rebatelist[$key]['trade_user_id']);
			$rebatelist[$key]['trade_username'] = $sub_user_info['username'];
		}

		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$rebatelist];		
	}

	public function drawLists(){
        $user_id = is_login();
		if(!$user_id){
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>[]];			
		}		
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');

		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'create_time';
		    $order[0]['dir'] = 'desc';
		}
		//var_dump($order_name);		
		$classdb = new Draw();
		$count = $classdb->where('user_id',$user_id)->where('money','like', ['%'.$search['value'].'%'])->count();			
		$draw  = $classdb->where('user_id',$user_id)->where('money','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$drawlist = $draw->toArray();

		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$drawlist];		
	}
}
