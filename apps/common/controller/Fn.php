<?php
namespace app\common\controller;

use Request;

class Fn
{
    public function getModule()
    {
        $request = request();
		return $request->module();
		
    }
	public function getController()
    {
        $request = request();	
        return $request->controller();
    }
    public function getAction()
    {
        $request = request();	
        return $request->action();
    }
	public function getNode(){
		$request = request();
		return $request->module().'/'.$request->controller().'/'.$request->action();
	}
	public function getIndex()
    {
        $request = request();	
        return $request->module().'/'.$request->controller().'/index';
    }
}
