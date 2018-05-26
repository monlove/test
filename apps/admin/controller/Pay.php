<?php
namespace app\admin\controller;

use app\admin\model\Pays;
use think\Db;
use Config;

class Pay extends Base
{

    /**
     * @node 应用管理
	 * 
     *
     */		
    public function index()
    {
        	
        //dump(config('alipay_config.seller_email'));exit;		
        return $this->fetch();
    }
    /**
     * @node 保存设置
	 * 
     *
     */		
    public function inConfig(\think\Request $request)
    {
        if($request->isPost()){
		    $inputs = input('post.');
//			$result = $this->validate(
//              $inputs,
//              [
//                  'seller_id'         => 'require',
//                  'seller_email' => 'require',
//                  'key'    => 'require',
//              ],
//              [
//                  'seller_id'         => '合作者id不能为空',
//                  'seller_email' => '支付宝账号不能为空',
//                  'key'    => '私钥不能为空',
//              ]
//			);
//          if(true !== $result){
//               // 验证失败 输出错误信息
//              $this->error($result);
//          }
	    	$confile = \Env::get('root_path').'config/alipay_config.php';
			//dump($confile);			

			update_config($confile,'partner',$inputs['seller_id']);
			update_config($confile,'seller_id',$inputs['seller_id']);
			update_config($confile,'key',$inputs['key']);
			update_config($confile,'seller_email',$inputs['seller_email']);
			
	    	$this->success('修改成功');
			
	    }

    }	
  
}
