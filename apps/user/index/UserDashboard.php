<?php
namespace app\user\index;

use app\index\controller\Base;
use app\user\model\Users;
use Request;
use Session;
use Cookie;

//仪表盘
class UserDashboard extends Base
{
    public function index()
    {
        if(is_login()){
       		
       	    return $this->fetch();
        }
	    $this->redirect('index/User/login');
	
        
    }

}
