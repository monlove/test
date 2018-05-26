<?php
namespace app\admin\controller;

use think\Request;
use app\admin\model\Configs;

class System extends Base
{
    /**
     * @node 系统设置
	 * 
     *
     */		
    public function index()
    {
        	//dump(config('site.'));exit;
		//$this->assign('systemdb',$systemdb);	
        return $this->fetch();
    }
    /**
     * @node 保存设置
	 * 
     *
     */		
    public function inConfig(Request $request)
    {
        if($request->isPost()){
		    $inputs = input('post.');
            if(empty($inputs['site_switch'])){
            	$inputs['site_switch'] = 'off';				
            }
			
            foreach($inputs as $name => $value){
            	//dump($value);
            	if($name != 'file'){
            		$configs = Configs::get(['name'=>$name]);
                    $configs->value  = $value;
                    $configs->save();
            		
            	}

            }
						
        }
		$this->success('修改成功');
    }
}
