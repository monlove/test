<?php
namespace app\user\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\common\controller\AuthNode;
use app\user\model\AuthRule;
use app\user\model\AuthGroup; 
use Request;

class Role extends Base
{
    /**
     * @node 角色管理
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
     * @node 角色列表
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
		//var_dump($order_name);		
		$authgroup = new AuthGroup();
		$count = $authgroup->where('title','like', ['%'.$search['value'].'%']) ->count();			
		$role  = $authgroup->where('title','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$rolelist = $role->toArray();

		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$rolelist];
	}
	

    /**
     * @node 添加
	 * 
     *
     */		
	public function add()
	{
        $rolelist= AuthGroup::all(['status' => 1]);
		$rulelist= AuthRule::all(['status' => 1]);
		$this->assign('rolelist',$rolelist);
		$this->assign('rulelist',$rulelist);	
        return $this->fetch();
	}	
    /**
     * @node 确认添加
	 * 
     *
     */		
	public function inAdd()
	{
        if(Request::instance()->isPost()){
        	$inputs = input('post.');
			$result = $this->validate(
                $inputs,
                [
                    'title'  => 'require',                
                ],
                [
                    'title'  => '角色名不能为空',                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
						
			$role = new AuthGroup;
			$rest = $role->inAdd($inputs); 
			return $rest;
        }
		
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
	{
        $id= input('param.id');
		$roledb = AuthGroup::get($id);
        $rolelist= AuthGroup::all(['status' => 1]);
		$rulelist= AuthRule::all(['status' => 1]);
		$this->assign('roledb',$roledb);
		$this->assign('rolelist',$rolelist);
		$this->assign('rulelist',$rulelist);	
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
        	$inputs = input('post.');
			$result = $this->validate(
                $inputs,
                [
                    'title'  => 'require',                
                ],
                [
                    'title'  => '角色名不能为空',                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
						
			$role = new AuthGroup;
			$rest = $role->inEdit($inputs); 
			return $rest;
        }
	}
	
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
     	    AuthGroup::destroy(input('param.action_id'));
			$this->success('删除成功');
        }
		return ['code'=>41002,'msg'=>'数据有误'];
			
	}
    /**
     * @node 停用
	 * 
     *
     */		
	public function stop(){
		if(Request::instance()->isPost()){
     	    $authgroup=AuthGroup::get(input('param.action_id'));
			$authgroup->status = 0;
			$authgroup->save();
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
     	    $authgroup=AuthGroup::get(input('param.action_id'));
			$authgroup->status = 1;
			$authgroup->save();
			$this->success('启用成功');
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
        	$authgroup = new AuthGroup();
			foreach($tables as $data){
			    $authgroup->where('id',$data)->update(['status' => 1]);
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
        	$authgroup = new AuthGroup();
			foreach($tables as $data){
				if($data > 1){
					$authgroup->where('id',$data)->update(['status' => 0]);
				}
			    
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
        	AuthGroup::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}				
}
