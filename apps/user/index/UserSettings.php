<?php
namespace app\user\index;

use app\index\controller\Base;
use app\user\model\Users;
use Request;
use Session;
use Cookie;

//设置
class UserSettings extends Base
{
    public function index()
    {
        if(is_login()){
       		
       	    return $this->fetch();
        }
	    $this->redirect('index/User/login');
	
        
    }
	
	public function inSettings(){
		if(!is_login()){
        	return ['code'=>70004,'msg'=>'请先登录'];
        }
		
		if($this->request->isPost()){
			$indata=input('post.');
			$result = $this->validate(
                $indata,
                [
                    'email'  => 'require',
                    'qq'     => 'require',
                    'mobile' => 'require',
                ],
                [
                    'email'  => '邮箱不能为空',
                    'qq'     => 'qq号码不能为空',
                    'mobile' => '手机号不能为空',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$indata['user_id'] = session('user_auth.user_id');
            $classdb = Users::get($indata['user_id']);
			$classdb->email  = $indata['email'];
			$classdb->qq     = $indata['qq'];
			$classdb->mobile = $indata['mobile'];
			$classdb->save();
			
			return ['code'=>1,'msg'=>'更新成功'];
					
			//return ['code'=>1,'msg'=>'success','content'=>'创建成功,为您转到登录页面'];			
		}
		$this->error('数据错误');				
		
	}

}
