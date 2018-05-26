<?php
namespace app\app\model;

use think\Model;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsConsts;
use app\app\model\AppsVariables as AppsVar;
use app\app\model\AppsUserVar;
use Session;
use Validate;
use think\helper\Hash;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use App;

class AppsUser extends Model
{
    //protected $auto = ['create_user_id'];
	protected $resultSetType = 'collection';
	
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	public function users(){
		return $this->hasMany('\\app\\user\\model\\Users','id','user_id');
	}
	public function user(){
		return $this->hasOne('\\app\\user\\model\\Users','id','user_id');
	}
	public function getAppUser($data)
	{
		$data['connect_time'] = ceil(App::getBeginTime());
		$apps = Apps::get($data['app_id']);
        $const = new AppsConsts();//常量
		$constdb = $const->where('app_id',$data['app_id'])
		->where('status',1)
		->field('app_id,create_time,update_time,status',true)
		->select();
		$constdb = $constdb->toArray(); 
		//默认变量
        $var = new AppsVar();
		$vardb = $var
		->where('app_id',$data['app_id'])
		->where('status',1)
		->field('app_id,create_time,update_time,status',true)
		->select();
		//用户变量
		$uservar = AppsUserVar::all(['user_id'=>$data['user_id']]);
		foreach($vardb as $key=>$val){
			$vardb[$key]['value'] = $vardb[$key]['default_value'];
			foreach($uservar as $k => $v){				
				if($vardb[$key]['id'] == $uservar[$k]['variable_id'] && $uservar[$k]['value']){
					$vardb[$key]['value'] = $uservar[$k]['value'];
				}
			}			
		}		
		$appuserdb = $this
		->where('app_id',$data['app_id'])
		->where('user_id',$data['user_id'])->find();
		if($appuserdb){
			if($apps->use_way === 'points'){
				if($appuserdb['points']){
					$restdata=[
			            'points'         => $appuserdb['points'],
			            'connect_time'   => $appuserdb->connect_time,
			            'connect_ip'     => $appuserdb->connect_ip,
			            'connect_count'  => $appuserdb->connect_count,
			            'comment'        => $appuserdb->comment,
			            'user_data'      => $appuserdb->user_data,
			            'consts'          => $constdb, 
			            'variables'       => $vardb,    
			        ];
					return restApi(1,'认证成功',$restdata);
				}				
				return restApi(20038,'用户点数不足');
			}
			if($apps->bind_ip === 'on'){
				if($data['connetc_ip'] != $appuserdb['bind_ip'] && $appuserdb['bind_ip'] != 'not'){
					return restApi(20035,'绑定的IP不正确,请解除绑定');
				}
				$this->allowField(true)->save(['bind_ip'=>$data['connetc_ip']],['id' => $appuserdb['id']]);								
			}
			if($apps->bind_device_code === 'on'){
				if($data['bind_device_code'] != $appuserdb['bind_device_code'] && $appuserdb['bind_device_code'] != 'not'){
					return restApi(20036,'绑定的设备不正确,请解除绑定');
				}
				$this->allowField(true)->save(['bind_device_code'=>$data['bind_device_code']],['id' => $appuserdb['id']]);								
			}
			if($appuserdb['status'] < 1){
				return restApi(20037,'用户已被禁用此应用');
			}
			if($appuserdb['expire_time'] < ceil(App::getBeginTime()) && $appuserdb['unlimited_status'] === 'off' && $apps->use_way != 'free'){
				return restApi(20038,'用户使用已过期,到期时间'.timeTodate($appuserdb['expire_time']));
			}
						
			$restdata=[
			    'expire_time'    => timeTodate($appuserdb->expire_time),
			    'connect_time'   => $appuserdb->connect_time,
			    'connect_ip'     => $appuserdb->connect_ip,
			    'connect_count'  => $appuserdb->connect_count,
			    'comment'        => $appuserdb->comment,
			    'user_data'      => $appuserdb->user_data,
			    'consts'          => $constdb, 
			    'variables'       => $vardb,    
			];
			$updata=[
                'connect_time'=>ceil(App::getBeginTime()),
                'connect_ip'=>$data['connetc_ip'],
                'connect_count'=>$appuserdb->connect_count + 1,
            ];
			if($apps->use_way == 'free'){
				$restdata['expire_time']='free';
				return restApi(1,'认证成功',$restdata);
			}
			if($appuserdb['unlimited_status'] === 'on'){
				$restdata['expire_time']='unlimited';
				return restApi(1,'认证成功',$restdata);
			}
			return restApi(1,'认证成功',$restdata);			
		}
        
        $indata=[
            'app_id'            => $data['app_id'],
            'points'            => $apps['tryout_points'],
            'user_id'           => $data['user_id'],
            'expire_time'       => ceil(App::getBeginTime()) + ($apps['tryout_time']*60),
            'connect_time'      => ceil(App::getBeginTime()),
            'connect_ip'        => $data['connetc_ip'],
            'connect_count'     => 1,
            'bind_ip'           => $data['connetc_ip'],
            'bind_device_code'  => $data['bind_device_code'],
            'tryout_ip'         => $data['connetc_ip'],
            'tryout_device_code'=> $data['bind_device_code']
        ];
		
        $tryoutdb = $this
        ->where('tryout_ip', $data['connetc_ip'])
		->where('tryout_device_code', $data['bind_device_code'])
        ->find();
		if($tryoutdb){
			$indata['expire_time'] = ceil(App::getBeginTime());
			$indata['points'] = 0;
			$this->data($indata);
			$this->allowField(true)->save();
			if($apps->use_way === 'points'){
				return restApi(20038,'用户点数不足');
			}
			return restApi(20038,'用户使用已过期,到期时间'.timeTodate($indata['expire_time']));
		}
        $this->data($indata);
		$this->allowField(true)->save();
		$restdata=[		    
		    'expire_time'    => $indata['expire_time'],
		    'connect_time'   => $indata['connect_time'],
		    'connect_ip'     => $indata['connect_ip'],
		    'connect_count'  => $indata['connect_count'],
		    'consts'          => $constdb,
		    'variables'       => $vardb,     
		];
		if($apps->use_way === 'points'){
			$restdata['points'] = $indata['points'];
            unset($restdata['expire_time']);
		}
        return restApi(1,'认证成功',$restdata);
		
	}
    public function userUnbind($data){
    	$appdb = Apps::get($data['app_id']);

		if(empty($appdb)){
			return restApi(20046,'应用不存在.');
		}
		$user = Users::get(['username' => $data['username']]);
		if(empty($user)){
			return restApi(20047,'用户不存在.');
		}
		if(!Hash::check((string)$data['username'].$data['password'],$user->password)){
			return restApi(20048,'密码不正确.');	
		}
		$appuser = $this->where(['app_id'=>$data['app_id'],'user_id'=>$user->id])->find();
		if(empty($appuser)){
			return restApi(20049,'用户未激活应用.');
		}
		if($appdb['use_way'] == 'points'){
			if($appuser->points < $appdb->unbind_dec_points){
			    return restApi(20050,'点数不足无法解绑');
		    }
			$this->where('app_id',$data['app_id'])->where('user_id',$user->id)->setDec('points',$appdb->unbind_dec_points);
			$resdata= ['points'=>$appdb->unbind_dec_points];
			return restApi(1,'解绑成功',$resdata);
		}		
		
		
		$this->allowField(true)->save(['bind_ip' => 'not','bind_device_code'=>'not'],['id' => $data['app_id']]);
		$unbinddectime = $appdb->unbind_dec_time*60;
		$expiretime = $appuser->expire_time - ceil(App::getBeginTime());
		if($expiretime < $unbinddectime){
			return restApi(20050,'时间不足无法解绑.');
		}
		$this->where('app_id',$data['app_id'])->where('user_id',$user->id)->setDec('expire_time',$unbinddectime);
		if($user->score < $appdb->unbind_dec_score){
			return restApi(20050,'积分不足无法解绑.');
		}	
		$users = new Users();
        $users->where('id',$user->id)->setDec('score',$appdb->unbind_dec_score);
		
		$resdata =['dec_time'=>$unbinddectime,'dec_score'=>$appdb->unbind_dec_score]; 
		return restApi(1,'解绑成功',$resdata);
		
    }

    public function userRecharge($data){
    	$card = Card::get([
    	    'card_number'           => $data['card_number'],
    	    'app_id'         => $data['app_id']
    	]);
		
		if(empty($card)){
			return restApi(20040,'充值卡不存在');
		}
		if(empty($card['status'])){
			return restApi(20099,'充值卡已停用');
		}
		if($card['use_time']){
			return restApi(20099,'充值卡已使用');
		}
        $card_type = CardType::get([
            'id'             => $card['card_type_id'],
            'status'         => 1
        ]);		
		if(empty($card_type)){
			return restApi(20041,'充值卡类型错误');
		}
    	$user = Users::get(['username' => $data['username']]);
		if(empty($user) || $user->status < 1){
			return restApi(20042,'用户不存在或已被停用');
		}
        $resdb = $this->where(['app_id'=>$data['app_id'],'user_id'=>$user->id,])->find();
		if(empty($resdb)){
			return restApi(20043,'用户未激活此应用,请登录一次自动激活');
		}
		if($resdb->unlimited_status === 'on'){		
			return restApi(20044,'用户永不过期,无需充值');
		}
		$app_db = Apps::get($data['app_id']);
		if($app_db['use_way'] == 'free'){
			return restApi(20044,'免费应用,无需充值');
		}
		if($app_db['use_way'] == 'points' && $card_type['unit'] != 'points' && $card_type['unit'] != 'unlimited'){
			return restApi(20044,'卡类型和应用计费方式不同');
		}
		if($app_db['use_way'] != 'points' && $card_type['unit'] == 'points' && $card_type['unit'] != 'unlimited'){
			return restApi(20044,'卡类型和应用计费方式不同');
		}
		$restdb = $this->userAppSet($resdb->id,$card_type->unit,$card_type->value,$resdb->expire_time,$resdb->points);
		if($restdb){
			$card->user_id = $user->id;
			$card->use_time = ceil(App::getBeginTime());
			$card->client_ip = $data['client_ip'];
			$card->save();
			$resdb = $this->where('id',$resdb->id)->find();
		    if($resdb->unlimited_status === 'on'){
			    $restdata = ['username'=>$data['username'],'surplus_value'=>'永久使用'];
		        return restApi(1,'充值成功',$restdata);
		    }
			if($app_db['use_way'] == 'time'){
				$res_val = timeTodate($resdb['expire_time']);
			}else if($app_db['use_way'] == 'points'){
				$res_val = $resdb['points'];
			}
		    $restdata = ['username'=>$data['username'],'surplus_value'=>$res_val];
		    return restApi(1,'充值成功',$restdata);
		}
		
		return restApi(20045,'充值失败,数据有误.');
    }
    
    //用户充值
    protected function userAppSet($id,$unit,$num,$expire_time,$points){
    	
		switch ($unit)
        {
            case 'month': //月
                return $this->userAppSetInc($id,30*24*3600*$num,$expire_time);
                break;  
            case 'week':  //周
                return $this->userAppSetInc($id,7*24*3600*$num,$expire_time);
                break;  
            case 'day':   //天
                return $this->userAppSetInc($id,24*3600*$num,$expire_time);
                break; 
            case 'year':  //年
                return $this->userAppSetInc($id,365*24*3600*$num,$expire_time);
                break; 
			case 'unlimited': //永久
                return $this->userAppUnlimited($id);
                break;
			case 'points': //点
                return $this->userAppSetIncPoints($id,$num);
                break;		         
            default:      //分钟
            return $this->userAppSetInc($id,60*$num,$expire_time);           
        }
	}
		
	//用户加时
	protected function userAppSetInc($id,$set_inc_time,$expire_time){
		
		if($expire_time > App::getBeginTime()){
			$rest = $this->where('id',$id)->setInc('expire_time',$set_inc_time);
			return $rest; 
		}
		$rest = $this->save(['expire_time' => App::getBeginTime() + $set_inc_time],['id' => $id]);
		return $rest; 
		
	}
	//用户无限时
    protected function userAppUnlimited($id){
		$rest = $this->save(['unlimited_status' => 'on'],['id' => $id]);
		return $rest; 		
	}
	//用户加点
	protected function userAppSetIncPoints($id,$num){
		$rest = $this->where('id',$id)->setInc('points',$num);
		return $rest; 		
	}
}
