<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [
    // 支付宝账号
    'seller_email'=>'3718217@qq.com',
	// 收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号                   
	'partner'=>'',
	// 合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm	
	'seller_id'=>'',
	// MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
	'key'=>'',
	// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
    'notify_url'    => Request::instance()->domain().Request::instance()->root()."/index/ali_pay/notifyurl",
	// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
    'return_url'    => Request::instance()->domain().Request::instance()->root()."/index/ali_pay/returnurl",
	//签名方式
    'sign_type'     =>strtoupper('MD5'),
    //字符编码格式 目前支持 gbk 或 utf-8
    'input_charset' => strtolower('utf-8'),
    //ca证书路径地址，用于curl中ssl校验
    //请保证cacert.pem文件在当前文件夹目录中'cacert'        => getcwd().VENDOR_PATH.'\\cacert.pem',
    'cacert'        => APP_PATH.'extend\alipay\cacert.pem',
    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'transport'     => 'http',
    // 支付类型 ，无需修改
    'payment_type'  => "1",		
    // 产品类型，无需修改
    'service'       => "create_direct_pay_by_user",
    //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
    //↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓	
    // 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
    'anti_phishing_key' => "",	
    // 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
    'exter_invoke_ip'   => "",		
            //↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑	

];
