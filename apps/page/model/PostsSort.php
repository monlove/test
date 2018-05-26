<?php
namespace app\page\model;

use think\Model;
use think\Session;

class PostsSort extends Model
{
	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	
	public function getPostNum($value)
	{
		$rest = Posts::where('sort_id',$value)->count();
		return $rest;
	}
	

}
