<?php
namespace app\app\model;

use think\Model;
use app\user\model\Users;
use app\app\model\SiteApps;
use Session;
use Validate;
use Config;


class SiteAppsAuthorize extends Model
{
    
	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
    public function getAuthorTypeTextAttr($value)
    {
        $title = ['not'=>'未经授权','free'=>'免费版','business'=>'商业版'];
        return $title[$value];
    }
	public function getSiteApp($value)
    {
        $siteapps = SiteApps::get($value);
        return $siteapps;
    }	

}
