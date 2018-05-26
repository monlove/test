<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\user\model\Users;
use app\app\model\AppsUser;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use Request;
use think\Db;
use App;

class AppRechargeCard extends Base
{
    /**
     * @node 充值卡管理
	 * 
     *
     */		
    public function index()
    {
        $app_id = '';
		if(input('?get.app_id')){
			$app_id = input('param.app_id');
		}
		$app_db = Apps::get($app_id);
		$this->assign('app_db',$app_db); 	
        return $this->fetch();
    }
    /**
     * @node 卡列表
	 * 
     *
     */		
	public function lists()
	{
		$draw    = input('param.draw');			
		$start   = input('param.start');	
		$length  = input('param.length');
		$search  = input('param.search/a');
		$order   = input('param.order/a');
		$columns = input('param.columns/a');
		$app_id  = input('param.app_id');
		$where_use  = ['use_time','<',1];
		$where_sell = ['sell_time','<',1];
		$where_stop = TRUE;
		if(input('param.is_use') === 'true'){
			$where_use  = ['use_time','>',1];
        }
		if(input('param.is_sell') === 'true'){
			$where_sell  = ['sell_time','>',1];
        }
		if(input('param.is_stop') === 'true'){
			$where_stop  = FALSE;
        }
        
		$where_is = ['use_time'=>$where_use,'sell_time'=>$where_sell,'status'=>$where_stop];
		//dump(input('param.is_use'));exit;
		
		
		if($order[0]['column'] && $order[0]['dir']){
			$order_name = $columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
			
		$card   = new Card();
		$count = $card->where('card_number','like', ['%'.$search['value'].'%'])->where($where_is) ->count();			
		$carddb   = $card->where('card_number','like', ['%'.$search['value'].'%'])->where($where_is) ->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		if($app_id){
			$count = $card->where('card_number','like', ['%'.$search['value'].'%'])->where($where_is) ->where('app_id',$app_id) ->count();			
		    $carddb   = $card->where('card_number','like', ['%'.$search['value'].'%'])->where($where_is) ->where('app_id',$app_id)->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		}
		
		$applist = $carddb->toArray();
		foreach($applist as $key=>$val){
			$applist[$key]['app_name'] = Apps::where('id',$applist[$key]['app_id'])->value('name');
			if($applist[$key]['sell_time']){
				$applist[$key]['sell_time'] = timeTodate($applist[$key]['sell_time']);
			}else{
				$applist[$key]['sell_time'] = '未售';
			}
			if($applist[$key]['use_time']){
				$applist[$key]['use_time'] = timeTodate($applist[$key]['use_time']);
			}else{
				$applist[$key]['use_time'] = '未使用';
			}
			if($applist[$key]['user_id']){
				$applist[$key]['user_id'] = Users::where('id',$applist[$key]['user_id'])->value('username');
			}
			$applist[$key]['card_type'] = CardType::where('id',$applist[$key]['card_type_id'])->value('name'); 
		}
        	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$applist];
	}

    /**
     * @node 添加
	 * 
     *
     */	    
	public function add()
    {
        $app_id = input('param.app_id');
		$appdb  = Apps::get($app_id);
		$typelist = CardType::all(['status'=>1]); 
		$this -> assign('typelist',$typelist);
		$this -> assign('appdb',$appdb);
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */		
	public function inAdd(){		
		if(Request::instance()->isPost()){
			$inputs=input('post.');			
			$cardlist = $this->makecard(18,$inputs['card_prefix'],$inputs['create_num'],$inputs['app_id'],$inputs['card_type_id'],$inputs['comment']);
                     	
            $card = new Card;
			if($card->count()>=3000 && config('site_check')['author_type'] == 'free'){
			    $this->error('error');
            }
				
            $card->saveAll($cardlist);
            
			$this->success('添加成功','',$cardlist);
		}				
	}
    /**
     * @node 删除
	 * 
     *
     */		
    public function del(){
        if(Request::instance()->isPost()){
     	    Card::destroy(input('param.action_id'));
			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}
    /**
     * @node 停用
	 * 
     *
     */		
	public function stop(){
		if(Request::instance()->isPost()){
     	    $card=Card::get(input('param.action_id'));
			if($card->use_time > 1){
				
				$this->error('已用卡不可操作');
			}
			$card->status = 0;
			$card->save();
			$this->success('停用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 启用
	 * 
     *
     */		
	public function start(){
		if(Request::instance()->isPost()){
     	    $card=Card::get(input('param.action_id'));
			if($card->use_time > 1){
				$this->error('已用卡不可操作');
			}
			$card->status = 1;
			$card->save();
			$this->success('启用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 批量启用
	 * 
     *
     */		
	public function startList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$card = new Card();
			foreach($tables as $data){
			    $card->where('id',$data)->update(['status' => 1]);
			}
        	$this->success('启用成功');
		}
		$this->error('失败,未选中数据');
	}
	/**
     * @node 批量禁用
	 * 
     *
     */	
	public function stopList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$card = new Card();
			foreach($tables as $data){
			    $card->where('id',$data)->update(['status' => 0]);
			}
        	$this->success('停用成功');
		}
		$this->error('失败,未选中数据');
	}
    /**
     * @node 批量删除
	 * 
     *
     */					
	public function delList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	Card::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	

    /**
     * @node 生成卡
	 * 
     *
     */	
    protected function makecard($len=18, $card_prefix,$num=1,$app_id,$card_type_id,$comment='not') {
	    $sNumArr=range(0,9);
        $sArr=array_merge($sNumArr,range('a','z'));
        $cards=array();
        for($x=0;$x< $num;$x++){       
            $tempStr=array();
            for($i=0;$i< $len;$i++){
                $tempStr[]=$sArr[array_rand($sArr)];
            }
            $cards[$x]['card_number']=$card_prefix.strtoupper(md5(implode('',$tempStr).App::getBeginTime()));
		    $cards[$x]['app_id']=$app_id;
		    $cards[$x]['card_type_id']=$card_type_id;
			$cards[$x]['create_user_id']=session('user_auth.user_id');
        }
    //array_unique($cards);

	    return $cards;
    }
	
}
