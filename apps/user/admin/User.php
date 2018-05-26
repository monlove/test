<?php
namespace app\user\admin;

use app\admin\controller\Base;
use app\user\model\Users;
use app\user\model\AuthGroup;
use app\user\model\AuthGroupAccess as AuthRole;
use app\app\model\AppsAgent;
use app\app\model\AppsAgentUser;
use app\app\model\AppsAgentDraw;
use app\app\model\AppsAgentRebate;
use app\app\model\AppsRechargeCard;
use app\app\model\AppsUser;
use app\common\model\Logs;
use app\app\model\AppsUserVar;
use app\app\model\AppsUserToken;
use Request; 
use think\helper\Hash;
use auth\Auth;

class User extends Base
{
	
    /**
     * @node 用户管理
	 * 
     *
     */		

    public function index()
    {
        		 	
        return $this->fetch();
    }
    /**
     * @node 用户列表
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
		$user  = new Users();
		$count = $user->where('id','>',1)->where('username','like', ['%'.$search['value'].'%']) ->count();			
		$user  = $user->where('id','>',1)->where('username','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$userlist = $user->toArray();
		foreach($userlist as $key=>$data){
			$userlist[$key]['address'] = ipGetAddress($data['create_ip']);
		}

		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$userlist];
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
	public function inAdd()
	{
		if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                'username'   => 'require|length:3,25|chsAlphaNum',
                //'mobile'     => 'number|length:11',
                'password'   => 'require|min:5',
                'enpassword' => 'require|min:5|confirm:password',
                ],
                [
                'username'     => '用户名必须是汉字,字母或数字',
                //'mobile'       => ['code'=>70002,'msg'=>'fail','content'=>'手机号码必须是11位长度数字'],
                'password'     => '密码至少5位以上字符',
                'enpassword'   => '确认密码至少5位以上字符,并与密码相同',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$indata['create_ip']=$this->request->ip();
			$register = new Users();
			$rest = $register -> inRegister($indata);
			return $rest;
			
			
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');        
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
	{
        $input   = input('param.');
		if(empty($input['user_id'])){
			$input['user_id'] = session('user_auth.user_id');
		}
		$userdb = Users::get($input['user_id']);
        $rolelist= AuthGroup::all(['status' => 1]);
		$auth = Auth::instance();
		$group = $auth->getGroups($input['user_id']);
		if($group){
			$userdb['group'] = $group[0];
		}
		
		//dump($userdb);		
		$this->assign('userdb',$userdb);
		$this->assign('rolelist',$rolelist);				 
        return $this->fetch();
	}
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
	{
		if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                    'user_id'   => 'require|number',
                    'group_id'   => 'require|number',
                ],
                [
                    'user_id'     => '没有找到该用户',
                    'group_id'     => '请选择一个用户组',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$users = new Users();
			$rest = $users -> where('id',$indata['user_id'])->find();
			$authgroup = AuthGroup::get($indata['group_id']);
			 
			if(empty($rest)){
				return restApi(7006,'用户不存在');
			}
			if(empty($authgroup)){
				return restApi(7007,'角色不存在');
			}
			if($indata['password']){
				$indata['password'] = Hash::make((string)$rest['username'].$indata['password']);
				$users->allowField(true)->save($indata,['id' => $indata['user_id']]);
			}			
			$authrole = new AuthRole;
			$authrole-> setUserRole($indata['user_id'],$indata['group_id']);									
			$this->success('编辑成功');
			
			
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');        
	}
	
    /**
     * @node 删除
	 * 
     *
     */	
    public function del(){
        if(Request::instance()->isPost()){
        	$user_id = input('param.action_id');
			AuthRole::where('uid',$user_id)->delete();
			AppsAgent::where('user_id',$user_id)->delete();
			AppsAgentDraw::where('user_id',$user_id)->delete();
		    AppsAgentRebate::where('user_id',$user_id)->delete();
			AppsAgentUser::where('user_id',$user_id)->delete();
			AppsRechargeCard::where('user_id',$user_id)->delete();
			AppsUser::where('user_id',$user_id)->delete();
			AppsUserToken::where('user_id',$user_id)->delete();
			AppsUserVar::where('user_id',$user_id)->delete();
			Logs::where('user_id',$user_id)->delete();
			AppsUser::where('user_id',$user_id)->delete();
     	    Users::destroy($user_id);
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
     	    $user = Users::get(input('param.action_id'));
			$user->status = 0;
			$user->save();
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
     	    $user=Users::get(input('param.action_id'));
			$user->status = 1;
			$user->save();
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
        	$user = new Users();
			foreach($tables as $data){
			    $user->where('id',$data)->update(['status' => 1]);
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
        	$user = new Users();
			foreach($tables as $data){
			    $user->where('id',$data)->update(['status' => 0]);
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
			//dump($in_user_id);exit;				
        	Users::destroy($tables);
			$in_user_id = implode(',',$tables);
			AuthRole::where('uid','=',$in_user_id)->delete();
			AppsAgent::where('user_id','=',$in_user_id)->delete();
			AppsAgentDraw::where('user_id','=',$in_user_id)->delete();
		    AppsAgentRebate::where('user_id','=',$in_user_id)->delete();
			AppsAgentUser::where('user_id','=',$in_user_id)->delete();
			AppsRechargeCard::where('user_id','=',$in_user_id)->delete();
			AppsUser::where('user_id','=',$in_user_id)->delete();
			AppsUserToken::where('user_id','=',$in_user_id)->delete();
			AppsUserVar::where('user_id','=',$in_user_id)->delete();
			Logs::where('user_id','=',$in_user_id)->delete();
			AppsUser::where('user_id','=',$in_user_id)->delete();
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}
			
}
