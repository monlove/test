<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\BlockLists;
use app\user\model\Users;
use Request;
use Config;

class BlockList extends Base
{

    /**
     * @node 应用管理
	 * 
     *
     */		
    public function index()
    {
        return $this->fetch();
    }
	
    /**
     * @node 应用列表
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
		$class_rest  = new BlockLists();
		$count = $class_rest->where('value','like', ['%'.$search['value'].'%']) ->count();			
		$block  = $class_rest->where('value','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$blocklist = $block->toArray();
		//dump(config('block_list.block_type'));
        foreach($blocklist as $key=>$val){
        	$blocklist[$key]['type_obj'] = config('block_list.block_type')[$blocklist[$key]['type']];
        }
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$blocklist];
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
			$inputs=input('post.');
            $result = $this->validate(
                $inputs,
                [
                'type'         => 'require',
                'value'   => 'require',
                
                ],
                [
                'type'         => '名称不能为空',
                'value'   => '值不能为空',
                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
			$class_rest = BlockLists::create($inputs);			
				
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
		$block_db = BlockLists::get($input['app_id']);
		$this->assign('block_db',$block_db);		 
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
                'type'         => 'require',
                'value'   => 'require',
                
                ],
                [
                'type'         => '名称不能为空',
                'value'   => '值不能为空',
                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
			$class_ress = new BlockLists();			
			
            $class_ress->allowField(true)->save($inputs,['id'=>$inputs['block_id']]);
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
     	    Apps::BlockLists(input('param.action_id'));

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
     	    $apps=BlockLists::get(input('param.action_id'));
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
     	    $apps=BlockLists::get(input('param.action_id'));
			$apps->status = 1;
			$apps->save();
			$this->success('成功启用为收费状态');
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
        	$apps = new BlockLists();
			foreach($tables as $data){
			    $apps->where('id',$data)->update(['status' => 1]);
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
        	$apps = new BlockLists();
			foreach($tables as $data){
			    $apps->where('id',$data)->update(['status' => 0]);
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

        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	BlockLists::destroy($tables);

			$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
