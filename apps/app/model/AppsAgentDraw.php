<?php
namespace app\app\model;

use think\Model;
use Session;

class AppsAgentDraw extends Model
{

	protected $resultSetType = 'collection';
	
    public function users(){
		return $this->hasMany('\\app\\user\\model\\Users','id','user_id');
	}
	public function user(){
		return $this->hasOne('\\app\\user\\model\\Users','id','user_id');
	}

}
