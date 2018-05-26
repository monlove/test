<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsConsts;
use app\app\model\AppsUser;
use app\app\model\AppsTimingCard as Card;
use app\app\model\AppsTimingCardType as CardType;
use Request;
use think\Db;

class AppConst extends Base
{
    /**
     * @node 常量管理
	 * 
     *
     */		
	public function add(){
		$input = input('param.');
		$app   = new apps();
		$appdb = $app->where('id',$input['app_id'])->find();		
		$this->assign('input',$input);
		$this->assign('appdb',$appdb);		
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
                'const'        => 'require',
                'value'        =>  'require',
                ],
                [
                'name'         => '名称 不能为空',
                'const'        => '常量名 不能为空',
                'value'        => '常量值 不能为空',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			
			$appconsts=new AppsConsts();			
			$resapp = $appconsts
				->where('app_id',$update['app_id'])
			    ->where('const',$update['const'])
			    ->find();
			if($resapp){
				$this->error('失败 存在相同常量名');
			}
						
			$app=new AppsConsts();
			if($app->count()>=10 && config('site_check')['author_type'] == 'free'){
			    $this->error('error');
            }
			$app->data($update);
            $app->save();					
			$this->success('添加成功');
		}				
			
		
		$this->success('添加成功');
		
	}
    /**
     * @node 编辑
	 * 
     *
     */	
    public function edit(){
		$input   = input('param.');
		$constdb = AppsConsts::get($input['const_id']);
		$app     = new apps();
		$appdb   = $app->where('id',$constdb['app_id'])->find();
		
		$this->assign('constdb',$constdb);
		$this->assign('appdb',$appdb);
		
		return $this->fetch();
				
	}
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit(){
		if(Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'name'         => 'require',
                'const'        => 'require',
                'value'        =>  'require',
                ],
                [
                'name'         =>'名称 不能为空',
                'const'        => '常量名 不能为空',
                'value'        => '常量值 不能为空',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }

			
			$app_consts=new AppsConsts();			
			
			$resappname = $app_consts
			    ->where('app_id',$inputs['app_id'])
			    ->where('id','neq',$inputs['const_id'])
			    ->find();
            $resappconst = $app_consts
                ->where('app_id',$inputs['app_id'])
			    ->where('id','<>',$inputs['const_id'])
			    ->where('const',$inputs['const'])
			    ->find();
			if($resappname || $resappconst){
				$this->error('失败 存在相同常量名');
			}
			
			
			if(empty($inputs['auth_status'])){
				$auth_status='off';
			}else{
				$auth_status='on';
			}
			
			$update = ['name'=>$inputs['name'],'const'=>$inputs['const'],'value'=>$inputs['value'],'auth_status'=>$auth_status];
						
			$app=new AppsConsts();
            $app->save($update,['id'=>$inputs['const_id']]);					
			$this->success('编辑成功');
		}				
			
		
		$this->error('数据有误');
		
	}
    /**
     * @node 删除
	 * 
     *
     */	    
	public function del(){
        if(Request::instance()->isPost()){
     	    AppsConsts::destroy(input('param.action_id'));
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
     	    $consts=AppsConsts::get(input('param.action_id'));
			$consts->status = 0;
			$consts->save();
			$this->success('禁用成功');
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
     	    $consts=AppsConsts::get(input('param.action_id'));
			$consts->status = 1;
			$consts->save();
			$this->success('启用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 常量列表
	 * 
     *
     */		
	public function lists(){
		$app_id=input('param.app_id');
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
			
		$app  = new AppsConsts();
		$count = $app->where('name','like', ['%'.$search['value'].'%'])->where('app_id',$app_id) ->count();			
		$app  = $app->where('name','like', ['%'.$search['value'].'%']) ->where('app_id',$app_id) ->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$applist = $app->toArray();
        	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$applist];
		
		
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
        	$appconst = new AppsConsts();
			foreach($tables as $data){
			    $appconst->where('id',$data)->update(['status' => 1]);
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
        	$appconst = new AppsConsts();
			foreach($tables as $data){
			    $appconst->where('id',$data)->update(['status' => 0]);
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
        	AppsConsts::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}		
	
}
