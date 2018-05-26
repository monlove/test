<?php
namespace app\app\model;

use think\Model;
use app\app\model\Apps;
use Session;

class AppsGoods extends Model
{
	protected $resultSetType = 'collection';
	
	function getAppIdTextAttr($value,$data){
        $app_db = Apps::get($value);
        return $app_db[$data['name']];		
	}
	
}
