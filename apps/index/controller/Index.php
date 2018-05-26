<?php
namespace app\index\controller;

use think\Loader;
use app\index\controller\Base;
use Request;

class Index extends Base
{
    public function index()
    {
			
        $page_data = ['title'=>'首页'];	        
		$this->assign('page_data',$page_data);
        return $this->fetch();

    }
	
}
