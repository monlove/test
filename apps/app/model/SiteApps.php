<?php
namespace app\app\model;

use think\Model;
use app\user\model\Users;
use Session;

class SiteApps extends Model
{
    protected $auto = ['create_user_id'];
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	public function getCreateUserIdAttr($value)
    {
        $user = new Users();
		$user = $user->where('id',$value)->value('username');
        return $user;
    }
	
	public function setCreateUserIdAttr($value,$data)
    {       
	    return session('user.user_id');
    }

	

}
