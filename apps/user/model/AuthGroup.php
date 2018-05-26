<?php
namespace app\user\model;

use think\helper\Hash;
use think\Model;
use think\auth\Auth;

class AuthGroup extends Model
{
    public function getStatusTextAttr($value,$data)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	
	public function inAdd($data){
		$role = $this->where('title',$data['title'])->find();
		if($role){
			
			return restApi(40001,'同角色名已存在');
		}

		$data['rules']=implode(',',$data['rules_auth']);
		$this->data($data);
		$this->save();
		return restApi(1,'添加成功',$data);
	}
	public function inEdit($data){
		$role = $this->where('title',$data['title'])->where('id','<>',$data['group_id'])->find();
		if($role){
			return restApi(40001,'同角色名已存在');
		}

		$data['rules']=implode(',',$data['rules_auth']);
		$this->data($data);
		$this->allowField(true)->save($data,['id'=>$data['group_id']]);
		return restApi(1,'修改成功',$data);
	}
}
