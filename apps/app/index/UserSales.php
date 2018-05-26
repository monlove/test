<?php
namespace app\app\index;

use app\index\controller\Base;
use app\user\model\Users;
use Request;
use app\index\model\TradeRecord as Record;
use Session;
use Cookie;

//消费记录
class UserSales extends Base
{
    public function index()
    {
        $user_id = is_login();
		if($user_id){
            $record['count'] = Record::where('user_id',$user_id)->where('trade_status','<>','TRADE_ACTION')->count();
			$record['sum']   = Record::where('user_id',$user_id)->where('trade_status','<>','TRADE_ACTION')->sum('total_fee');
			$this->assign('record',$record);
            return $this->fetch();			
		}	
        $this->redirect('index/User/login');
    }
    public function lists(){
    	$user_id = is_login();
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');
				
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'desc';
		}
			
		$classdb  = new Record();
		$count   = $classdb->where('user_id',$user_id)->where('trade_status','<>','TRADE_ACTION')->where('subject','like', ['%'.$search['value'].'%']) ->count();			
		$app_db  = $classdb->where('user_id',$user_id)->where('trade_status','<>','TRADE_ACTION')->where('subject','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$applist = $app_db->toArray();

		if($user_id){
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$applist];          		
		}        
		
		return $this->error('数据错误');
    }
}
