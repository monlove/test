<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\AppsGoods;
use app\app\model\AppsPrice;
use app\app\model\Apps;
use app\app\model\TradeRecord;
use Request;
use think\Db;


class AppGoods extends Base
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
			
		$calssdb  = new AppsGoods();
		$count = $calssdb->where('title','like', ['%'.$search['value'].'%']) ->count();			
		$resdb = $calssdb->where('title','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$dblist = $resdb->toArray();
		foreach($dblist as $key=>$val){
			$app_db = Apps::get(['id'=>$dblist[$key]['app_id']]);
			$price_db = AppsPrice::where('app_id',$dblist[$key]['app_id'])->column('id');
			//$dblist[$key]['sales_volume'] = TradeRecord::where('price_id',implode(',',$price_db))->sum('total_fee');
            $dblist[$key]['app_name'] = $app_db['name'];
						
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
        	
        $app_id = AppsGoods::where('status',1)->column('app_id');
					
        $app_list = Apps::where('id','not in',implode(',', $app_id))->select();
		$this->assign('app_list',$app_list);        	
//dump($app_list->toArray());exit;
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
			$result = $this->validate(
                $update,
                [
                'app_id'        => 'number',
                'title'         => 'require',
                
                ],
                [
                'app_id'        => '请选择一个应用',
                'title'         => '标题不能为空',               
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			
			$price = AppsPrice::all(['app_id'=>$update['app_id']]);
			$price = $price->toArray();
			if(empty($price)){
				$this->error('请先设置应用价格才可发布商品');
			}
			$resdb = AppsGoods::get(['title' => $update['title']]);
			if($resdb){
				$this->error('存在相同标题');
			}			
			$classdb = new AppsGoods();
			$classdb->data($update);
            $classdb->save();
			$this->success('用户不存在',['goods_id'=>$classdb->id,'title'=>$update['title']]);
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
		$goods_db = AppsGoods::get($input['goods_id']);
		$goods_db['app_name'] = Apps::where('id',$goods_db->app_id)->value('name');
		$this->assign('goods_db',$goods_db);		 
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
                'app_id'        => 'number',
                'title'         => 'require',
                
                ],
                [
                'app_id'        => '请选择一个应用',
                'title'         => '标题不能为空',               
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$classdb=new AppsGoods();						
			$resdb = $classdb
			    ->where('id','neq',$inputs['goods_id'])
			    ->where('title',$inputs['title'])
			    ->find();
			if($resdb){
				$this->error('失败 存在相同名称');
			}
									
			$classdb=new AppsGoods();
            $classdb->allowField(true)->save($inputs,['id'=>$inputs['goods_id']]);	
			$this->success('编辑成功',['goods_id'=>$inputs['goods_id'],'title'=>$inputs['title']]);
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
     	    AppsGoods::destroy(input('param.action_id'));
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
     	    $resdb=AppsGoods::get(input('param.action_id'));
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
		if(Request::instance()->isPost()){
     	    $resdb=AppsGoods::get(input('param.action_id'));
			$resdb->status = 1;
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
        	$classdb = new AppsGoods();
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
        	$classdb = new AppsGoods();
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
        	AppsGoods::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
