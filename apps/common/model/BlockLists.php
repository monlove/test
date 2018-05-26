<?php
namespace app\common\model;

use think\Model;

class BlockLists extends Model
{
	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }


	

}
