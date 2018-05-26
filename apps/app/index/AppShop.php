<?php
namespace app\app\index;

use think\Loader;
use app\index\controller\Base;
use app\app\model\AppsGoods as Goods;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\user\model\Users;
use app\app\model\AppsPrice;
use Config;

class AppShop extends Base
{
    public function index()
    {
        $page_data['title'] = '应用商店';
						
		$goods_list['new'] = $this->getNewGoodsList();
		$goods_list['sellers'] = $this->getSellersGoodsList();
		$goods_list['browse'] = $this->getBrowseGoodsList();
		//dump($goods_list['new']);exit;
		$this->assign('page_data',$page_data);
		$this->assign('goods_list',$goods_list);
		
        return $this->fetch();

    }
	
	public function lists()
	{
		
		return $this->fetch();
	}
	
    public function news()
    {
        $page_data['title'] = '最新应用';
						
		$goods_list['new'] = $this->getNewGoodsList();
		$goods_list['sellers'] = $this->getSellersGoodsList();
		$goods_list['browse'] = $this->getBrowseGoodsList();
		//dump($goods_list['new']);exit;
		$this->assign('page_data',$page_data);
		$this->assign('goods_list',$goods_list);
		
        return $this->fetch();

    }
    public function sellers()
    {
        $page_data['title'] = '销量排行';
						
		$goods_list['new'] = $this->getNewGoodsList();
		$goods_list['sellers'] = $this->getSellersGoodsList();
		$goods_list['browse'] = $this->getBrowseGoodsList();
		//dump($goods_list['new']);exit;
		$this->assign('page_data',$page_data);
		$this->assign('goods_list',$goods_list);
		
        return $this->fetch();

    }
    public function browse()
    {
        $page_data['title'] = '热门商品';
						
		$goods_list['new'] = $this->getNewGoodsList();
		$goods_list['sellers'] = $this->getSellersGoodsList();
		$goods_list['browse'] = $this->getBrowseGoodsList();
		//dump($goods_list['new']);exit;
		$this->assign('page_data',$page_data);
		$this->assign('goods_list',$goods_list);
		
        return $this->fetch();

    }
    public function goods()
    {
        $input = input('param.');
		
		$goods_db = Goods::get($input['id']);
        $goods_db['user_count'] = AppsUser::where('app_id',$goods_db['app_id'])->count();
		$goods_db['user_list'] = AppsUser::where('app_id',$goods_db['app_id'])->order('id', 'desc')->limit(10)->select();
		foreach($goods_db['user_list'] as $key=>$val){
			$goods_db['user_list'][$key]['user_db'] = Users::get($goods_db['user_list'][$key]['user_id']);
		}
		$goods_db['app_db'] = Apps::get($goods_db['app_id']);
		if($goods_db['app_db']['use_way'] == 'points'){
			$goods_db['price_list'] = AppsPrice::all(['app_id'=>$goods_db['app_id'],'unit'=>'points']);
		}else{
			$goods_db['price_list'] = AppsPrice::where('app_id',$goods_db['app_id'])->where('unit','<>','points')->select();
		}
		
		
		$this->assign('goods_db',$goods_db);
				
		$page_data['title'] = $goods_db['title'];      
		$this->assign('page_data',$page_data);
		
        return $this->fetch();

    }
	
	public function getPrice(){		
		$price_id = input('param.price_id');
		$price_db = AppsPrice::get($price_id);
		$rest_data = $price_db->toArray();
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');

		$rest_data['info'] = $rest_data['unit_num'].'&nbsp;&nbsp;'.config('unit.'.$rest_data['unit'])['title'];
		return $rest_data;		
	}		
    //新品	
	protected function getNewGoodsList(){
		$gools_list = Goods::where('status',1)->order('id', 'desc')->select();
		foreach($gools_list as $key=>$val){
			$gools_list[$key]['app_price'] = AppsPrice::where('app_id',$gools_list[$key]['app_id'])->select();
		}
		$arrays = $gools_list->toArray();
		$rest=[];
		foreach($arrays as $key => $val){
			if(count($arrays[$key]['app_price']) >= 1){
				$rest[]=$arrays[$key];
			}
		} 
		
		return $rest;	
	}
	//热销
	protected function getSellersGoodsList(){
		$gools_list = Goods::where('status',1)->order('sales_num', 'desc')->select();
		foreach($gools_list as $key=>$val){
			$gools_list[$key]['app_price'] = AppsPrice::where('app_id',$gools_list[$key]['app_id'])->select();
		}
		$arrays = $gools_list->toArray();
		$rest=[];
		foreach($arrays as $key => $val){
			if(count($arrays[$key]['app_price']) >= 1){
				$rest[]=$arrays[$key];
			}
		} 
		
		return $rest;	
	}
	//访问量
	protected function getBrowseGoodsList(){
		$gools_list = Goods::where('status',1)->order('access_num', 'desc')->select();
		foreach($gools_list as $key=>$val){
			$gools_list[$key]['app_price'] = AppsPrice::where('app_id',$gools_list[$key]['app_id'])->select();
		}
		$arrays = $gools_list->toArray();
		$rest=[];
		foreach($arrays as $key => $val){
			if(count($arrays[$key]['app_price']) >= 1){
				$rest[]=$arrays[$key];
			}
		} 
		
		return $rest;	
	}	
}
