<?php
namespace app\app\validate;

use Validate;

class TimingCard extends Validate
{
    protected $rule =   [
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',
        'app_id'  => '',   
    ];
    
    protected $message  =   [
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',    
    ];
    
    protected $scene = [
        'edit'  =>  ['name','age'],
    ];
    
}