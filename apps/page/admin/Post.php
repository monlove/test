<?php
namespace app\page\admin;

use app\admin\controller\Base;
use think\Db;
use app\page\model\Posts;
use app\page\model\PostsSort;

class Post extends Base
{
    /**
     * @node 文章管理
	 * 
     *
     */		
    public function index()
    {
        return $this->fetch();
    }
	
    /**
     * @node 例表
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
			
		$calssdb  = new Posts();
		$count = $calssdb->where('title','like', ['%'.$search['value'].'%']) ->count();			
		$resdb = $calssdb->where('title','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$dblist = $resdb->toArray();
		foreach($dblist as $key=>$val){
			$dblist[$key]['sort'] = '未定议';
			if($dblist[$key]['sort_id']){
				$sort = PostsSort::get(['id'=>$dblist[$key]['sort_id']]);
				$dblist[$key]['sort'] = $sort['name'];
			}
			
			
		}
        	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$dblist];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
        $sortdb = PostsSort::all();
		$sortlist = sortDir($sortdb);
		
		$this->assign('sortlist',$sortlist);        	

        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inAdd(){		
		if(\Request::instance()->isPost()){
			$update=input('post.');
			$result = $this->validate(
                $update,
                [
                'title'         => 'require',
                
                ],
                [
                'title'         => '标题不能为空',               
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$resdb = Posts::get(['title' => $update['title']]);
			if($resdb){
				return ['code'=>60003,'msg'=>'存在相同标题'];
			}			
			$classdb = new Posts();
			$classdb->data($update);
            $classdb->save();
								
			return restApi(1,'添加成功',['post_id'=>$classdb->id,'title'=>$update['title']]);
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
		$postdb = Posts::get($input['post_id']);
        $sortdb = PostsSort::all();
		$sortlist = sortDir($sortdb);		
		$this->assign('sortlist',$sortlist);   		
		$this->assign('postdb',$postdb);		 
        return $this->fetch();
    }
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
    {
        if(\Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'title'         => 'require',
                
                ],
                [
                'title'         => '标题不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$classdb=new Posts();			
			
			$resdb = $classdb
			    ->where('id','neq',$inputs['post_id'])
			    ->where('title',$inputs['title'])
			    ->find();
			if($resdb){
				$this->error('失败 存在相同应用名称');
			}
									
			$classdb=new Posts();
            $classdb->allowField(true)->save($inputs,['id'=>$inputs['post_id']]);					
			return restApi(1,'编辑成功',['post_id'=>$inputs['post_id'],'title'=>$inputs['title']]);
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(\Request::instance()->isPost()){
     	    Posts::destroy(input('param.action_id'));
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
		if(\Request::instance()->isPost()){
     	    $resdb=Posts::get(input('param.action_id'));
			$resdb->status = 0;
			$resdb->save();
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
		if(\Request::instance()->isPost()){
     	    $resdb=Posts::get(input('param.action_id'));
			$resdb->status = 2;
			$resdb->save();
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
        	$classdb = new Posts();
			foreach($tables as $data){
			    $classdb->where('id',$data)->update(['status' => 1]);
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
        	$classdb = new Posts();
			foreach($tables as $data){
			    $classdb->where('id',$data)->update(['status' => 0]);
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
        	Posts::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
