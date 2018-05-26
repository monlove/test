<?php
namespace app\app\model;

use think\Model;
use Session;

class AppsConsts extends Model
{
    protected $resultSetType = 'collection';
	  	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	
	public function users(){
		return $this->hasMany('\\app\\user\\model\\Users','id','user_id');
	}
	public function user(){
		return $this->hasOne('\\app\\user\\model\\Users','id','user_id');
	}
}
