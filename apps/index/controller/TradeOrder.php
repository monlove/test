<?php
namespace app\index\controller;

use think\Loader;
use app\index\controller\Base;
use app\index\model\TradeRecord;
use app\app\model\AppsGoods;
use app\app\model\AppsPrice;

class TradeOrder extends Base
{
    public function index()
    {
		$trade_record = TradeRecord::get(input('param.record'));
		
        $page_data['title'] = $trade_record['subject'].' - 订单页面';
		
		$this->assign('trade_record',$trade_record); 	
		$this->assign('page_data',$page_data); 						
        return $this->fetch();
    }
    public function create()
    {
        if(is_login()){
            $inputs = input('param.');
		    $goods_db = AppsGoods::get($inputs['goods_id']);
		    $price_db = AppsPrice::get($inputs['price_id']);
               
		    $trade_record = TradeRecord::create([
                'subject'   => $goods_db['title'],//订单名称
                'total_fee' => $price_db['price'],//付款金额
                'body'      => '用户ID'.is_login().' | '.$goods_db['title'].' | '.$price_db['name'],//内容
                'user_id'   => is_login(),
                'price_id'  => $price_db['id'],
            ]); 
			$this->redirect('index/TradeOrder/index', ['record' => $trade_record->id]);       	
        }else{
        	$this->redirect('index/User/login');
        }
						
        
    }	
}
