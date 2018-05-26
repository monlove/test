<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\Logs;
use app\user\model\Users;
use Request;
use think\Db;
use Config;

class Log extends Base
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
			
		$class_rest  = new Logs();
		$count = $class_rest->where('comment','like', ['%'.$search['value'].'%']) ->count();			
		$rest_db  = $class_rest->where('comment','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$log_list = $rest_db->toArray();
		$log_type = config('log_config.log_type');
		foreach($log_list as $key=>$val){
			$log_list[$key]['user'] =Users::get($log_list[$key]['user_id']);
			$log_list[$key]['type'] = $log_type[$log_list[$key]['type']];
			$log_list[$key]['address'] = ipGetAddress($val['client_ip']);
		}
        
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$log_list];
	}

    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
     	    Logs::destroy(input('param.action_id'));

			$this->success('删除成功');
        }
		$this->error('数据有误');
			
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
        	Logs::destroy($tables);
			$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}
	public function delAll(){
		if($this->request->isPost()){
        	Logs::where('1=1')->delete();
			$this->success('清空成功');
        }
	}	
  
}
