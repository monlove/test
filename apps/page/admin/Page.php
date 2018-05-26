<?php
namespace app\page\admin;

use app\admin\controller\Base;
use app\page\model\Pages;
use app\page\model\PagesTheme;
use think\Db;
use Config;
use Env;

class Page extends Base
{
    /**
     * @node 页面管理
	 * 
     *
     */		
    public function index()
    {
        return $this->fetch();
    }

    /**
     * @node 页面列表
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
			
		$classdb  = new Pages();
		$count = $classdb->where('title','like', ['%'.$search['value'].'%']) ->count();			
		$restdb  = $classdb->where('title','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$restlist = $restdb->toArray();
        	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$restlist];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
		$themedb =PagesTheme::get(['name'=>'theme_path']);	
		Config::load(Env::get('root_path').'theme/'.$themedb['path'].'/pagetype/config.php');	
		$restdb = Pages::all();
		$pagelist = sortNode($restdb);
		$this->assign('pagelist',$pagelist);				 
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
                'title'         => '页面标题不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$restdb = Pages::get(['title' => $update['title']]);
			if($restdb){
				return ['code'=>60003,'msg'=>'存在相同标题'];
			}		
			$classdb=new Pages();
			$classdb->data($update);
            $classdb->save();					
								
			return restApi(1,'添加成功',['page_id'=>$classdb->id,'title'=>$update['title']]);
		}				
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
    {
		$themedb =PagesTheme::get(['name'=>'theme_path']);	
		Config::load(Env::get('root_path').'theme/'.$themedb['path'].'/tpl/config.php');       
	    $input   = input('param.');
		$pagedb = Pages::get($input['page_id']);
		$pagelist = Pages::all(['status',1]);
		$ordertree = $this->getSonNode($pagelist,$input['page_id']);
		$pagelists = db('pages')->where('id','not in',$ordertree)->select();	
		$pagelist = sortNode($pagelists);	
		$this->assign('pagedb',$pagedb);
		$this->assign('pagelist',$pagelist);		 
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
			$classdb=new Pages();			
			
			$restdb = $classdb
			    ->where('id','neq',$inputs['page_id'])
			    ->where('title',$inputs['title'])
			    ->find();
			if($restdb){
				return ['code'=>60003,'msg'=>'失败 存在相同标题'];
			}
			
						
			$classdb=new Pages();
            $classdb->allowField(true)->save($inputs,['id'=>$inputs['page_id']]);					
			return restApi(1,'编辑成功',['page_id'=>$inputs['page_id'],'title'=>$inputs['title']]);
		}				
    }
    /**
     * @node 取页面模板
	 * 
     *
     */	
    public function getType(){
        if(\Request::instance()->isPost()){
            $inputs=input('post.');
		    $themedb =PagesTheme::get(['name'=>'theme_path']);				
		    Config::load(Env::get('root_path').'theme/'.$themedb['path'].'/pagetype/config.php');
			$file = Env::get('root_path').'theme/'.$themedb['path'].'/pagetype/'. $inputs['type_name'].'.html';
						
            if (!file_exists($file)){
            	return restApi(12001,'模板不存在');
            }					
	        $str = file_get_contents($file);
			
			return restApi(1,'模板读取成功',$str);
        }
		return restApi(12002,'非法数据');
			
	}	
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(\Request::instance()->isPost()){
     	    Pages::destroy(input('param.action_id'));
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
     	    $restdb=Pages::get(input('param.action_id'));
			$restdb->status = 0;
			$restdb->save();
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
     	    $restdb=Pages::get(input('param.action_id'));
			$restdb->status = 1;
			$restdb->save();
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
        	$restdb = new Pages();
			foreach($tables as $data){
			    $restdb->where('id',$data)->update(['status' => 1]);
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
        	$restdb = new Pages();
			foreach($tables as $data){
			    $restdb->where('id',$data)->update(['status' => 0]);
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
        	Pages::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
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
