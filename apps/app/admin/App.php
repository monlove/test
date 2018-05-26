<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsConsts;
use app\app\model\AppsVariables;
use app\app\model\AppsUser;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use Request;
use think\Db;
use Config;

class App extends Base
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
			
		$app  = new Apps();
		$count = $app->where('name','like', ['%'.$search['value'].'%']) ->count();			
		$app  = $app->where('name','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$applist = $app->toArray();
		foreach($applist as $key=>$val){
			$applist[$key]['card_info'] = Card::where(['app_id'=>$applist[$key]['id'],'status'=>1])->where('use_time','<',1)->count().'/'.Card::where(['app_id'=>$applist[$key]['id'],'status'=>1])->count();
		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$applist];
	}
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
        	
        $unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
        
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
                'name'         => 'require',
                'secret_key'   => 'require',
                'use_way'      => 'require',
                ],
                [
                'name'         => '应用名不能为空',
                'secret_key'   => 'secret key 不能为空',
                'use_way'   => '请选择一个计费方式',
                ]
			);
            if(true !== $result){
                 $this->error($result);
                
            }
			$resapp = Apps::get(['name' => $update['name']]);
			if($resapp){
				$this->error('存在相同应名');
			}
			session('user.user_id',1);			
			$app=new Apps();
			if($app->count()>=2 && config('site_check')['author_type'] == 'free'){
			    $this->error('error');
            }
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
		$appsdb = Apps::get($input['app_id']);
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
		$this->assign('appsdb',$appsdb);		 
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
                'secret_key'   => 'require',
                
                ],
                [
                'name'         => '应用名不能为空',
                'secret_key'   => 'secret key 不能为空',
                
                ]
			);
            if(true !== $result){
                $this->error($result);
            }
			$apps=new Apps();			
			
			$resapp = $apps
			    ->where('id','<>',$inputs['app_id'])
			    ->where('name',$inputs['name'])
			    ->find();
			if($resapp){
				$this->error('存在相同应用名称.');
			}
			
			
			if(empty($inputs['bind_ip'])){
				$inputs['bind_ip']='off';
			}else{
				$inputs['bind_ip']='on';
			}
			if(empty($inputs['bind_device_code'])){
				$inputs['bind_device_code']='off';
			}else{
				$inputs['bind_device_code']='on';
			}
			
						
			$app=new Apps();
            $app->allowField(true)->save($inputs,['id'=>$inputs['app_id']]);
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
     	    Apps::destroy(input('param.action_id'));
			AppsConsts::where('app_id','=',input('param.action_id'))->delete();
			AppsVariables::where('app_id','=',input('param.action_id'))->delete();
			AppsUser::where('app_id','=',input('param.action_id'))->delete();
			Card::where('app_id','=',input('param.action_id'))->delete();
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
     	    $apps=Apps::get(input('param.action_id'));
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
     	    $apps=Apps::get(input('param.action_id'));
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
        	$apps = new Apps();
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
        	$apps = new Apps();
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
        	Apps::destroy($tables);
			AppsConsts::where('app_id','in',$tables)->delete();
			AppsVariables::where('app_id','in',$tables)->delete();
			AppsUser::where('app_id','in',$tables)->delete();
			Card::where('app_id','in',$tables)->delete();
			$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
