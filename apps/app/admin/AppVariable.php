<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsVariables as AppsVar;
use app\app\model\AppsUserVar;
use app\app\model\AppsUser;
use Request;
use think\Db;

class AppVariable extends Base
{
    /**
     * @node 变量管理
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
                'variable'        => 'require',
                ],
                [
                'name'         => '名称 不能为空',
                'variable'     => '变量名 不能为空',
			]);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			
			$classdb=new AppsVar();			
			$restvar = $classdb
			    ->where('app_id',$update['app_id'])
			    ->where('variable',$update['variable'])
			    ->find();

			if($restvar){
				$this->error('失败 存在相同常量名');
			}
						
			$classdb=new AppsVar();
			if($classdb->count()>=10 && config('site_check')['author_type'] == 'free'){
			    $this->error('error');
            }
			$classdb->data($update);
            $classdb->save();					
			$this->success('添加成功');
		}				
			
		
		$this->error('数据有误');
		
	}
    /**
     * @node 编辑
	 * 
     *
     */	
    public function edit(){
		$input   = input('param.');
		$vardb = AppsVar::get($input['variable_id']);
		$app     = new apps();
		$appdb   = $app->where('id',$vardb['app_id'])->find();
		
		$this->assign('vardb',$vardb);
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
                'variable'        => 'require',
                ],
                [
                'name'         => '名称 不能为空',
                'variable'        => '变量名 不能为空',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }

			
			$classdb=new AppsVar();			
			
			$restnamedb = $classdb
			    ->where('app_id',$inputs['app_id'])
			    ->where('id','neq',$inputs['variable_id'])
			    ->find();
            $restvardb = $classdb
                ->where('app_id',$inputs['app_id'])
			    ->where('id','<>',$inputs['variable_id'])
			    ->where('variable',$inputs['variable'])
			    ->find();
			if($restnamedb || $restvardb){
				$this->error('失败 存在相同变量名');
			}
			
			$update = ['name'=>$inputs['name'],'variable'=>$inputs['variable'],'default_value'=>$inputs['default_value']];						
			$classdb = new AppsVar();
            $classdb->save($update,['id'=>$inputs['variable_id']]);					
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
     	    AppsVar::destroy(input('param.action_id'));
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
     	    $restdb=AppsVar::get(input('param.action_id'));
			$restdb->status = 0;
			$restdb->save();
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
     	    $restdb=AppsVar::get(input('param.action_id'));
			$restdb->status = 1;
			$restdb->save();
			$this->success('启用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 常量
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
			
		$classdb = new AppsVar();
		$count = $classdb->where('name','like', ['%'.$search['value'].'%'])->where('app_id',$app_id) ->count();			
		$var = $classdb->where('name','like', ['%'.$search['value'].'%']) ->where('app_id',$app_id) ->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$varlist = $var->toArray();
        	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$varlist];
		
		
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
        	$classdb = new AppsVar();
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
        	$classdb = new AppsVar();
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
        	AppsVar::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}		
	
}
