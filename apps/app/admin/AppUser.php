<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsConsts;
use app\app\model\AppsUser;
use app\user\model\Users;
use Request;
use think\Db;
use Config;
use app\admin\model\Configs;
use app\push\model\AppsUserWs as UserWs;
use App;

class AppUser extends Base
{
    /**
     * @node 用户App管理
	 * 
     *
     */		
    public function index()
    {
        	
        $restapp = Apps::all();
		
		if(config('site_check')['author_type'] == 'free'){
			$restapp = Apps::limit(2)->select();;
        }
		$app_list = $restapp->toArray();
		$user_count = Users::count();
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
		foreach($app_list as $key=>$val){
            $app_list[$key]['active'] = AppsUser::where('app_id',$app_list[$key]['id'])->count();			
			$app_list[$key]['expire'] = AppsUser::where('app_id',$app_list[$key]['id'])->where('expire_time','<',App::getBeginTime())->count();
			$app_list[$key]['stop']   = AppsUser::where('status',0)->count();
			$app_list[$key]['use_way'] = $unit_config['use_way'][$app_list[$key]['use_way']];
			$app_list[$key]['user_ws'] = 1;//UserWs::where(['app_id'=>$app_list[$key]['id'],'status'=>1])->count();	
		}
		$this->assign('app_list',$app_list);        	
        	
        return $this->fetch();
    }
	
    /**
     * @node 用户App页
	 * 
     *
     */		
    public function userApp()
    {
        $param = input('param.');
		$param['app_db'] = Apps::get(['id'=>$param['app_id']]);		
      	$this->assign('param',$param);        	
        return $this->fetch();
    }	
    /**
     * @node 在线用户App页
	 * 
     *
     */		
    public function online()
    {
        $param = input('param.');
		$count = UserWs::where('sum','<>',0)->count();
		$this->assign('count',$count); 	
      	$this->assign('param',$param);        	
        return $this->fetch();
    }
	public function wsLists(){
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
		$count = UserWs::where('sum','<>',0)->count();
		$user_ws = UserWs::where('sum','<>',0)->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
			
		foreach ($user_ws as $key => $val) {
		   $user_db = Users::where('id',$val['user_id'])->find();
	       $user_ws[$key]['username'] = $user_db['username'];
		   $app_db = Apps::where('id',$val['app_id'])->find();
		   $user_ws[$key]['app_name'] = $app_db['name'];
		   $app_user_db = AppsUser::where('user_id',$val['user_id'])->where('app_id',$val['app_id'])->find();
		   $user_ws[$key]['client_ip'] = $app_user_db['connect_ip'];

		}
        $ws_list = $user_ws->toArray();
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$ws_list];		
	}
    /**
     * @node App用户列表
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
		$app_id=input('param.app_id');


		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
		$where[]= ['app_id','=',$app_id];
		if($search['value']){
			
			$user_id = Users::where('username',$search['value'])->value('id');
			if($user_id){
				$where[] = ['user_id','=',$user_id];
			}else{
				$where[] = ['user_id','=',''];
			}			
			
			
			
		}

		$count = AppsUser::where($where)->count();
		
        $app_user = AppsUser::where($where)
            ->order($order_name.' '.$order[0]['dir'])
            ->limit($start,$length)
            ->select();
        
        			
		foreach ($app_user as $key => $val) {
				//dump($val);	
			$val->username = $val->user->username;
			if($val->expire_time < 1){
				$val->expire_time = 'N/A';
			}else{
				$val->expire_time = timeTodate($val->expire_time);
			}			
			if($val->unlimited_status == 'on'){
				$val->expire_time = '<span class="label label-danger">无限期</span>';
			}

		}
        $app_user_list = $app_user->toArray();
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$app_user_list];
	}
    /**
     * @node 激活
	 * 
     *
     */		
    public function active()
    {

        return $this->fetch();
    }
    /**
     * @node 确认激活
	 * 
     *
     */	
	public function inActive(){		
		if(Request::instance()->isPost()){
			$update=input('post.');
			$result = $this->validate(
                $update,
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
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$resapp = Apps::get(['name' => $update['name']]);
			if($resapp){
				$this->error('存在相同应名');
			}
			session('user.user_id',1);			
			$app=new Apps();
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
		$app_user = AppsUser::get($input['id']);
		$app_user['user'] = Users::get($app_user->user_id);
		$app_user['app'] = Apps::get($app_user->app_id);
		$app_user['expire_time'] = timeTodate($app_user['expire_time']);
		$this->assign('app_user',$app_user);		 
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
                'app_user_id'         => 'require',
                ],
                [
                'app_user_id'         => '数据ID错误',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			if(isset($inputs['expire_time'])){
				$inputs['expire_time'] = strtotime($inputs['expire_time']);
			}
			
			if(empty($inputs['bind_ip'])){
				$inputs['bind_ip'] = 'not';				
			}
			if(empty($inputs['bind_device_code'])){
				$inputs['bind_device_code'] = 'not';				
			}						
			$app=new AppsUser();
            $app->allowField(true)->save($inputs,['id'=>$inputs['app_user_id']]);					
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
     	    AppsUser::destroy(input('param.action_id'));
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
     	    $apps=AppsUser::get(input('param.action_id'));
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
     	    $apps=AppsUser::get(input('param.action_id'));
			$apps->status = 1;
			$apps->save();
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
        	$app_user = new AppsUser();
			foreach($tables as $data){
			    $app_user->where('id',$data)->update(['status' => 1]);
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
        	$app_user = new AppsUser();
			foreach($tables as $data){
			    $app_user->where('id',$data)->update(['status' => 0]);
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
        	AppsUser::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
  
}
