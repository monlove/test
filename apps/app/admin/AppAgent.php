<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentSort as Sorts;
use app\app\model\AppsAgentDraw as AgentDraw;
use app\app\model\AppsAgentRebate as AgentRebate;
use Request;
use think\Db;
use Config;
use App;

class AppAgent extends Base
{
    /**
     * @node 代理管理
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
		$where[] = ['auth_time','>',1];
		if($search['value']){
			$user_id = Users::where('username',$search['value'])->value('id');
			if($user_id){
				$where[] = ['user_id','=',$user_id];
			}else{
				$where[] = ['user_id','=',''];
			}
		}
			
		
		$count = Agents::where($where) ->count();			
		$agent_user  = Agents::where($where)->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$agent_list = $agent_user->toArray();
		foreach ($agent_list as $key => $val) {
			$user_db = Users::get($agent_list[$key]['user_id']);
			$sort_db = Sorts::get($agent_list[$key]['sort_id']);
			$agent_list[$key]['user_count'] = \app\app\model\AppsAgentUser::where('agent_user_id',$agent_list[$key]['user_id'])->count();
			
			$agent_list[$key]['username'] = $user_db['username'];
			if($agent_list[$key]['auth_time'] > 1){
				$agent_list[$key]['auth_time'] = timeTodate($agent_list[$key]['auth_time']);
			}
            $agent_list[$key]['draw_total'] = AgentDraw::where('user_id',$agent_list[$key]['user_id'])->sum('actual_amount');
			$agent_list[$key]['rebate_total'] = AgentRebate::where('user_id',$agent_list[$key]['user_id'])->sum('rebate');
			$agent_list[$key]['agent_sort'] = $sort_db['name'];

		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$agent_list];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
        	
        $agent_sort_list = Sorts::all(['status'=>1]);
		$this->assign('agent_sort_list',$agent_sort_list);
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inAdd(){		
		if(Request::instance()->isPost()){
			
			$update=input('post.');
			//return $update;
			$result = $this->validate(
                $update,
                [
                'sort_id'         => 'require',                
                ],
                [
                'sort_id'         => '必需选择一项代理类型',                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
            if(empty($update['username']) && empty($update['user_id'])){
            	$this->error('请输入一个用户名或用户ID');
            }
			if($update['username']){
				$user_db = Users::get(['username'=>$update['username']]);
				if(empty($user_db)){
					$this->error('用户不存在');
				}
				$user_id = $user_db->id;
			}else{
				if($update['user_id']){
					$user_db = Users::get(['id'=>$update['user_id']]);
					if(empty($user_db)){
						$this->error('用户ID不存在');
					}
					$user_id = $user_db->id;
				}
			}
						
			$resapp = Agents::get(['user_id' => $user_id]);
			if($resapp){
				$this->error('用户已成为代理');
			}
			$indate=[
			    'user_id'=>$user_id,
			    'sort_id'=>$update['sort_id'],
			    'auth_time'=>App::getBeginTime(),
			    'status'=>1,
			];			
			$app=new Agents();
			$app->data($indate);
            $app->save();
			$this->success('添加成功');
		}				
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
    {
        $input   = input('param.');
		$agents = Agents::get(['id'=>$input['id']]);		
        $agent_db = $agents->toArray();
		$agent_db['user_db'] = Users::get(['id'=>$agent_db['user_id']]);
        $agent_sort_list = Sorts::all(['status'=>1]);
		//dump($agent_db);
		$this->assign('agent_db',$agent_db);
		$this->assign('agent_sort_list',$agent_sort_list);
        return $this->fetch();
    }
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
    {
        if(Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'sort_id'         => 'require',                
                ],
                [
                'sort_id'         => '必需选择一项代理类型',                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }						
			$model_db=new Agents();
            $model_db->allowField(true)->save($inputs,['id'=>$inputs['agent_id']]);	
			$this->success('编辑成功');
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
     	    Agents::destroy(input('param.action_id'));
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
     	    $apps=Agents::get(input('param.action_id'));
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
     	    $apps=Agents::get(input('param.action_id'));
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
        	$model_db = new Agents();
			foreach($tables as $data){
			    $model_db->where('id',$data)->update(['status' => 1]);
			}
			$this->success('启用成功');
		}
		$this->error('未选中数据');
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
        	$model_db = new Agents();
			foreach($tables as $data){
			    $model_db->where('id',$data)->update(['status' => 0]);
			}
			$this->success('停用成功');
		}
		$this->error('未选中数据');
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
        	Agents::destroy($tables);
			$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
	  
}
