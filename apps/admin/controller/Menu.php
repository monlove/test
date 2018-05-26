<?php
namespace app\admin\controller;

use app\common\controller\Common;
use app\admin\model\Menu as Menus;
use Request;

class Menu extends Base
{
	/**
     * @node 菜单管理
	 * @module 系统
     *
     */	
    public function index()
    {
        return $this->fetch();
    }
    /**
     * @node 添加
	 * @module 系统
     *
     */		
    public function add()
    {			
        $menus = new Common();
        $menu  = $menus->getPositionMenu('admin');	
		$menulist=sortOut($menu);
		$this->assign('menulist',$menulist);
//		echo '<pre>';
//		var_dump($menulist);	
			
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */		
	public function inAdd(Request $request){
		if($request->isPost()){
			$update=input('post.');
			$result = $this->validate(
                $update,
                [
                'name'         => 'require',
                
                ],
                [
                'name'         => '名称不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$resapp = Menus::get(['name' => $update['name']]);
			if($resapp){
				$this->error('存在相同应名');
			}			
			$classdb=new Menus();
			$classdb->data($update);
            $classdb->save();
			$this->success('添加成功');	
		}		
	}
}
