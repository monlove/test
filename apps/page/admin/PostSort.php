<?php
namespace app\page\admin;

use app\admin\controller\Base;
use app\page\model\PostsSort;
use think\Db;

class PostSort extends Base
{
    /**
     * @node 文章分类管理
	 * 
     *
     */		
    public function index()
    {
        $sortdb = PostsSort::all();
		$sortlist = sortDir($sortdb);
		
		$this->assign('sortlist',$sortlist);
			
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
			
		$classdb  = new PostsSort();
		$count = $classdb->where('name','like', ['%'.$search['value'].'%']) ->count();			
		$restdb  = $classdb->where('name','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$restlistdb = $restdb->toArray();
		$restlist = sortDir($restlistdb);
        foreach($restlist as $key=>$val){
        	$restlist[$key]['post_num'] = $classdb->getPostNum($restlist[$key]['id']);
        }	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$restlist];
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
		if(\Request::instance()->isPost()){
			$update=input('post.');
			$result = $this->validate(
                $update,
                [
                'name'         => 'require',
                
                ],
                [
                'name'         => '名称不能为空',                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$resapp = PostsSort::get(['name' => $update['name']]);
			if($resapp){
				$this->error('失败 存在相同名称');
			}		
			$app=new PostsSort();
			$app->data($update);
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
		$sort = PostsSort::get($input['sort_id']);
		$sortdb = PostsSort::all();
		$sortree = $this->getSonNode($sortdb,$input['sort_id']);
		$sortdb = db('posts_sort')->where('id','not in',$sortree)->select();
        //$sortdb = PostsSort::all('id','not in',$sortree);
		$sortlist = sortDir($sortdb);
					
		$this->assign('sort',$sort);	
		$this->assign('sortlist',$sortlist);				 
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
                'name'         => 'require',
                
                ],
                [
                'name'         => '分类名不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$classdb=new PostsSort();			
			
			$restdb = $classdb
			    ->where('id','neq',$inputs['sort_id'])
			    ->where('name',$inputs['name'])
			    ->find();
			if($restdb){
				$this->error('失败 存在相同名称');
			}
									
			$classdb=new PostsSort();
            $classdb->allowField(true)->save($inputs,['id'=>$inputs['sort_id']]);					
			$this->success('编辑成功');
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(\Request::instance()->isPost()){
        	$restdb = PostsSort::get(['parent_id'=>input('param.action_id')]);
			if($restdb){
				return restApi(40404,'请先删除或移动下级分类');
			}
			$postdb = \app\page\model\Posts::get(['sort_id'=>input('param.action_id')]);
			if($postdb){
				return restApi(40404,'请先删除或移动分类中的文章');
			}						
     	    PostsSort::destroy(input('param.action_id'));

			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}


	//递归取下级分类
	protected function getSonNode($data,$pid=0,$SonNode = array()){
        $SonNode[] = $pid;
        foreach($data as $k=>$v){
            if($v['parent_id'] == $pid){
                $SonNode = self::getSonNode($data,$v['id'],$SonNode);
            }
        }
        return $SonNode;
    }		
  
}
