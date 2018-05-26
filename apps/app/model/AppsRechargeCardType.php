<?php
namespace app\app\model;

use think\Model;
use app\user\model\Users;
use Session;

class AppsRechargeCardType extends Model
{

	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }


}
