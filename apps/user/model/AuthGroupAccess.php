<?php
namespace app\user\model;

use think\helper\Hash;
use think\Model;
use think\auth\Auth;

class AuthGroupAccess extends Model
{
    public function setUserRole($user_id,$group_id){
    	$resdb = $this->where('uid',$user_id)->find();
		if($resdb){
			$this->save(['group_id'=>$group_id],['uid'=>$user_id]);
			return restApi(1,'用户组设置成功',$group_id);
		}
		$this->data([
            'uid'      =>  $user_id,
            'group_id' =>  $group_id,
        ]);
        $this->save();
		return restApi(1,'用户组设置成功',$group_id);
    }

}
