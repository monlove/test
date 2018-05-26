<?php
namespace app\app\index;

use app\index\controller\Base;
use app\user\model\Users;
use app\app\model\AppsAgent;
use app\app\model\AppsAgentDraw as Draw;
use app\app\model\AppsAgentRebate as Rebate;
use app\app\model\AppsAgentSort as Sort;
use app\app\model\AppsAgentUser as AgentUser;
use app\app\model\AppsAgentCardInfo as AgentCard;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use app\app\model\Apps;
use Request;
use Session;
use Cookie;
use App;

//代理商信息
class AgentApp extends Base
{
    public function index()
    {
        $user_id = is_login();
		if($user_id){
			$where=['agent_user_id'=>$user_id,'status'=>1];
			$request = Request::instance();
            $unsold_num = Card::where('sell_time','<',1)->where('use_time','<',1)->where($where)->count();//未出售
			$sell_num = Card::where('sell_time','>',1)->whereOr('use_time','>',1)->where($where)->count();//已出售
			$use_num = Card::where('use_time','>',1)->where($where)->count();//已使用
			$sum_num = Card::where($where)->count();//总量
			$card_count_db = ['unsold_num'=>$unsold_num,'sell_num'=>$sell_num,'use_num'=>$use_num,'sum_num'=>$sum_num];
            $app_agent = AppsAgent::get(['user_id'=>$user_id]);
            $this->assign('card_count_db',$card_count_db);
            $this->assign('app_agent',$app_agent);
            return $this->fetch();			
		}	
        $this->redirect('index/User/login');
    }
	
	public function AppLists(){
        $user_id = is_login();
		if(!$user_id){
			
			
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>[]];			
		}
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
		    $order[0]['dir'] = 'asc';
		}
			
		$app  = new Apps();
		$count = $app->where('name','like', ['%'.$search['value'].'%']) ->count();			
		$app  = $app->where('name','like', ['%'.$search['value'].'%'])->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		$applist = $app->toArray();
		foreach($applist as $key=>$val){
			$where = ['app_id'=>$applist[$key]['id'],'status'=>1,'agent_user_id'=>$user_id];
			$applist[$key]['card_info'] = Card::where($where)->where('use_time','<',1)->count().'/'.Card::where($where)->where('sell_time','>',1)->count().'/'.Card::where($where)->where('use_time','>',1)->count().'/'.Card::where($where)->count();
			$applist[$key]['card_surplus'] = 0;
			$res_agent_card = AgentCard::where(['app_id'=>$applist[$key]['id'],'user_id'=>$user_id])->sum('rem_num');
			if($res_agent_card){
				$applist[$key]['card_surplus'] = $res_agent_card;
			} 
			 
		}				


		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$applist];		
	}

	public function Card(){
		$user_id = is_login();
		if($user_id){
            $app_id = '';
			if(input('?get.app_id')){
				$app_id = input('param.app_id');
			}
			$app_db = Apps::get($app_id);
			$this->assign('app_db',$app_db); 	
        	return $this->fetch();			
		}
		
	}

	public function cardLists(){
        $user_id = is_login();
		if(!$user_id){
            return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>[]];			
		}		
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
        
		$where_is = ['use_time'=>$where_use,'sell_time'=>$where_sell,'status'=>$where_stop,'agent_user_id'=>$user_id];
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
     * @node 批量已售
	 * 
     *
     */		
	public function setSell()
    {
    	$user_id = is_login();
		if(!$user_id){
            $this->error('失败');		
		}	
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$card = new Card();
			foreach($tables as $data){
			    $card->where('id',$data)->where('agent_user_id',$user_id)->update(['sell_time' => time()]);
			}
        	$this->success('启用成功');
		}
		$this->error('失败,未选中数据');
	}
    /**
     * @node 添加卡
	 * 
     *
     */	    
	public function addCard()
    {
    	$user_id = is_login();
		if($user_id){
            $app_agent = AppsAgent::get(['user_id'=>$user_id]);
            $this->assign('app_agent',$app_agent);
			$app_id = input('param.app_id');
		    $appdb  = Apps::get($app_id);
		    $typelist = CardType::all(['status'=>1]); 
			$where = ['app_id'=>$app_id,'user_id'=>$user_id];
			foreach($typelist as $key=>$val){
				$typelist[$key]['rem_num'] = 0;
				$agent_card = AgentCard::where($where)->where('card_type_id',$val['id'])->find();
				if($agent_card){
					$typelist[$key]['rem_num'] = $agent_card['rem_num'];
				}
				
			}
		    $this -> assign('typelist',$typelist);
		    $this -> assign('appdb',$appdb);
            return $this->fetch();			
		}
    }

    /**
     * @node 确认添加
	 * 
     *
     */		
	public function inAddCard(){		
		if(Request::instance()->isPost()){
			$user_id = is_login();
			if($user_id){
				if(config('site_check')['author_type'] == 'free'){
				    $this->error('error');
        	    }
				$inputs=input('post.');
				$where = ['app_id'=>$inputs['app_id'],'card_type_id'=>$inputs['card_type_id'],'user_id'=>$user_id];	
				$agent_card = AgentCard::where($where)->find();
				if(!$agent_card){
					$this->error('剩余可生成数不足,请与管理员联系!');
				}
				if($agent_card['rem_num'] < $inputs['create_num']){
					$this->error('剩余可生成数不足,请与管理员联系!');
				}
	
				$cardlist = $this->makecard(18,$inputs['card_prefix'],$inputs['create_num'],$inputs['app_id'],$inputs['card_type_id'],$inputs['comment'],$user_id);                     	
        	    $card = new Card;				
        	    $card->saveAll($cardlist);
                AgentCard::where($where)->setDec('rem_num',$inputs['create_num']);
				$this->success('添加成功','',$cardlist);				
			}

		}				
	} 
	
    /**
     * @node 生成卡
	 * 
     *
     */		    
    protected function makecard($len=18, $card_prefix,$num=1,$app_id,$card_type_id,$comment='not',$agent_user_id='') {
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
			$cards[$x]['agent_user_id']=$agent_user_id;
        }
    //array_unique($cards);

	    return $cards;
    }
}
