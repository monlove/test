<?php
namespace app\page\index;

use think\Loader;
use app\index\controller\Base;
use app\page\model\Pages;

class Page extends Base
{
    public function index()
    {
        	
        $param = input('param.');
		$page_data = Pages::get(['id'=>$param['id']]);
		
		if(empty($page_data)){
			$page_data = Pages::get(['url_name'=>$param['id']]);			
		}              
		$this->assign('page_data',$page_data);
        return $this->fetch();

    }
	
	public function lists()
	{
		
		return $this->fetch();
	}

}
