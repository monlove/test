<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentUser as AgentUser;
use app\app\model\TradeRecord;
use Request;
use think\Db;
use Config;

class AppAgentUser extends Base
{
    /**
     * @node 代理管理
	 * 
     *
     */		
    public function index()
    {
        $agent_db = Users::get(input('param.agent_user_id')); 	
        $this->assign('agent_db',$agent_db); 	
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
		$agent_user_id = input('param.agent_user_id');
		
        $user_id = Users::where('username','like', ['%'.$search['value'].'%'])->column('id');
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
			
		//dump(implode(',',$user_id));
		$count = AgentUser::where('user_id','in',implode(',',$user_id))->where('agent_user_id',$agent_user_id) ->count();			
		$model_list  = AgentUser::where('user_id','in', implode(',',$user_id))->where('agent_user_id',$agent_user_id)->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$agent_user_list = $model_list->toArray();
		
		foreach ($agent_user_list as $key => $val) {
			$where = [
			    'user_id' => $agent_user_list[$key]['user_id'],
			    'type'    => 'buy',
			];
			$user_db = Users::get($agent_user_list[$key]['user_id']);
			$agent_user_list[$key]['username'] = $user_db['username'];
            $agent_user_list[$key]['trade_total'] = TradeRecord::where($where)->where('trade_status','<>','TRADE_ACTION')->sum('total_fee');
		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$agent_user_list];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
        	
        $user_db = Users::get(input('param.agent_user_id'));
		$this->assign('user_db',$user_db);
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inAdd(){		
		if(Request::instance()->isPost()){
			
			$indate=input('post.');
			//return $update;
			$result = $this->validate(
                $indate,
                [
                'username'         => 'require',                
                ],
                [
                'username'         => '用户名不能为空',                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
		
			$restu_db = Users::get(['username' => $indate['username']]);
			//dump($restu_db->username);
			if(empty($restu_db)){
				$this->error('用户不存在');
			}
			$resta_db = AgentUser::get(['user_id'=>$restu_db['id']]);
			if($resta_db){
				$this->error('用户已在期它代理下');
			}
			$insdate=['user_id'=>$restu_db['id'],'agent_user_id'=>$indate['agent_user_id']];
			$app=new AgentUser();
			$app->data($insdate);
            $app->save();					
			$this->success('添加成功');
		}				
	}

    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
     	    AgentUser::destroy(input('param.action_id'));
			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}
    /**
     * @node 停用
	 * 
     *
     */		
	public function stop(){
		if(Request::instance()->isPost()){
     	    $apps=AgentUser::get(input('param.action_id'));
			$apps->status = 0;
			$apps->save();
			$this->success('停用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 启用
	 * 
     *
     */		
	public function start(){
		if(Request::instance()->isPost()){
     	    $apps=AgentUser::get(input('param.action_id'));
			$apps->status = 1;
			$apps->save();
			$this->success('成功,启用为收费状态');
        }
		$this->error('数据有误');
	}
    /**
     * @node 批量启用
	 * 
     *
     */		
	public function startList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$model_db = new AgentUser();
			foreach($tables as $data){
			    $model_db->where('id',$data)->update(['status' => 1]);
			}
        	$this->success('启用成功');
		}
		$this->error('失败,未选中数据');
	}
	/**
     * @node 批量禁用
	 * 
     *
     */	
	public function stopList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$model_db = new AgentUser();
			foreach($tables as $data){
			    $model_db->where('id',$data)->update(['status' => 0]);
			}
        	$this->success('停用成功');
		}
		$this->error('失败,未选中数据');
	}
    /**
     * @node 批量删除
	 * 
     *
     */					
	public function delList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	AgentUser::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}
	
	

		
  
}
