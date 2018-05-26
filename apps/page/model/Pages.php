<?php
namespace app\page\model;

use think\Model;
use app\user\model\Users;
use think\Session;

class Pages extends Model
{
    protected $auto = ['author'];
	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }

	
	public function setAuthorAttr($value,$data)
    {       
	    return session('user_auth.user_name');
    }
	
}
