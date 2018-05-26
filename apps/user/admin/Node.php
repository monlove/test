<?php
namespace app\user\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\common\controller\AuthNode;
use app\user\model\AuthRule; 
use Request;

class Node extends Base
{
    /**
     * @node 节点管理
	 * 
     *
     */	
    public function index()
    {
        $node = AuthRule::all();
		$this->assign('node',$node);	
        return $this->fetch();
    }
    /**
     * @node 节点列表
	 * 
     *
     */		
	public function lists()
	{

	}
    /**
     * @node 自动导入
	 * 
     *
     */		
	public function imports(){
		if(request()->isPost()){
			$inputs = input('post.');
			$controller = 'admin';
			if($inputs['module'] === 'admin'){
				$controller ='controller';
			}
		    $authnode = new AuthNode();
		    $nodes = $authnode->getNode($inputs['module'],$controller);
			$rule = AuthRule::all();
			
			foreach($rule as $key=>$val){
				foreach ($nodes as $k=>$v){
					if($inputs['module'] != 'admin'){
					    $nodes[$k]['name'] = str_replace($inputs['module'].'/','admin/',$nodes[$k]['name']);
				    }				
				    $nodes[$k]['module']=$inputs['module'];
				    $nodes[$k]['parent_id']=$inputs['parent_id'];
													
				    if($nodes[$k]['title'] === $rule[$key]['title'] && $nodes[$k]['name'] === $rule[$key]['name']){					
				        unset($nodes[$k]);						
				    }
                }
			}
			//dump($nodes);
			if(empty($nodes)){
				return restApi(30099,'无可导入的数据');
			}
						
		    $this->assign('nodes',$nodes);
			
			$authurle = new AuthRule;
            $authurle->saveAll($nodes);
		    return restApi(1,'导入成功');	
		}
		return restApi(30100,'数据错误');
	}
    /**
     * @node 添加
	 * 
     *
     */		
	public function add()
	{
        $node = AuthRule::all();       	
		$nodes = sortNode($node);	
		$this->assign('nodes',$nodes);
		
        return $this->fetch();
	}	
    /**
     * @node 确认添加
	 * 
     *
     */		
	public function inAdd()
	{

	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
	{

	}
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
	{

	}		
}
