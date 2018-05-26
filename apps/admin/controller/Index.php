<?php
namespace app\admin\controller;

use app\user\model\Users;
use Request;
use Env;
use Config;

class Index extends Base {
	/**
	 * @node 管理首页
	 *
	 *
	 */
	public function index() {
		$user = new Users();
		$usercount = $user -> count();
		$todayuser = $user -> getNewUser();
		$weekuser = $user -> getNewUser('week');
		$monthuser = $user -> getNewUser('month');
		$yearuser = $user -> getNewUser('year');
		$todayusers = $user -> getNewUserDay(1);
		$weekusers = $user -> getNewUserDay(7);
		$monthusers = $user -> getNewUserDay(30);
		$newuser = $user -> getNewUserNum(20);
		$this -> assign('usercount', $usercount);
		$this -> assign('weekuser', $weekuser);
		$this -> assign('todayuser', $todayuser);
		$this -> assign('monthuser', $monthuser);
		$this -> assign('yearuser', $yearuser);
		$this -> assign('todayusers', $todayusers);
		$this -> assign('weekusers', $weekusers);
		$this -> assign('monthusers', $monthusers);
		$this -> assign('newuser', $newuser);
				       
       
		
		return $this -> fetch();
	}
	


}
