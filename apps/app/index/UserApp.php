<?php
namespace app\app\index;

use app\index\controller\Base;
use app\user\model\Users;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsGoods;
use Request;
use Session;
use Cookie;
use App;

//我的应用
class UserApp extends Base
{
    public function index()
    {
        $user_id = is_login();
		if($user_id){
            $user_app_list = AppsUser::where('user_id',$user_id)->select()->toArray();
			foreach($user_app_list as $key=>$val){
				$app_db = Apps::get($user_app_list[$key]['app_id'])->toArray();
				if($app_db['use_way'] == 'points'){
					$user_app_list[$key]['expire'] = $user_app_list[$key]['points'].' 点';
				}
				if($app_db['use_way'] == 'free'){
					$user_app_list[$key]['expire'] = '免费';
				}
				if($app_db['use_way'] == 'time'){
					$user_app_list[$key]['expire'] = timeTodate($user_app_list[$key]['expire_time']);
				}
				if($user_app_list[$key]['unlimited_status'] == 'on'){
					$user_app_list[$key]['expire'] = '永不过期';
				}				
				$user_app_list[$key]['app_db'] =$app_db;
				$user_app_list[$key]['app_goods'] = '';
				$app_goods = AppsGoods::get(['app_id'=>$user_app_list[$key]['app_id']]);
				if($app_goods){
					$user_app_list[$key]['app_goods'] = $app_goods->toArray();
				}
				
			}
			$user_app['action_count'] = AppsUser::where('user_id',$user_id)->count();
			$user_app['expire_count'] = AppsUser::where('user_id',$user_id)->where('expire_time','<',App::getBeginTime())->count();
			$user_app['lists']         = $user_app_list;
			//dump($user_app);
			$this->assign('user_app',$user_app);
            return $this->fetch();			
		}	
        $this->redirect('index/User/login');
    }

}
