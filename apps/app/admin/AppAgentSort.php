<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent as Agents;
use app\app\model\AppsAgentSort as Sorts;
use Request;
use think\Db;
use Config;

class AppAgentSort extends Base
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
			
		//dump(implode(',',$user_id));
		$model_count = Sorts::where('name','like', ['%'.$search['value'].'%'])->count();			
		$model_list  = Sorts::where('name','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$model_list = $model_list->toArray();
		foreach ($model_list as $key => $val) {
			$model_list[$key]['agent_count'] = Agents::where('sort_id',$model_list[$key]['id'])->count();
			$model_list[$key]['rebate_ratio'] = (round($model_list[$key]['rebate_ratio'], 2)*100).'%';
			

		}
        
		return ['recordsTotal'=>$model_count,'recordsFiltered'=>$model_count,'draw'=>$draw,'data'=>$model_list];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
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
                'name'         => 'require', 
                'rebate_ratio' => 'float|elt:1',              
                ],
                [
                'name'         => '名称不能为空', 
                'rebate_ratio' => '返利率必需小于 或等于1',                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
						
			$rest = Sorts::get(['name' => $indate['name']]);
			if($rest){
				$this->error('存在相同名称');
			}
		
			$module_class=new Sorts();
			$module_class->data($indate);
            $module_class->allowField(true)->save();
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
		$model_class = Sorts::get(['id'=>$input['id']]);		
		$this->assign('sort_db',$model_class);
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
                'name'         => 'require', 
                'rebate_ratio' => 'float|elt:1',              
                ],
                [
                'name'         => '名称不能为空', 
                'rebate_ratio' => '返利率必需小于 或等于1',                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$rest = Sorts::where('id','<>',$inputs['sort_id'])->where('name',$inputs['name'])->find();
			if($rest){
				$this->error('存在相同名称');
			}						
			$model_db=new Sorts();
            $model_db->allowField(true)->save($inputs,['id'=>$inputs['sort_id']]);
								
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
     	    Sorts::destroy(input('param.action_id'));
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
     	    $apps=Sorts::get(input('param.action_id'));
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
     	    $apps=Sorts::get(input('param.action_id'));
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
        	$model_db = new Sorts();
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
        	$model_db = new Sorts();
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
        	Sorts::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
