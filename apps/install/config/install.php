<?php
// +----------------------------------------------------------------------
// | Rain OS PHP框架 [ Rain OS PHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 RainSoft [ http://www.rain68.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://rain68.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 安装程序配置文件
 */
return [
    //产品配置
    'product_name'   => 'Rain X', //产品名称
    'website_domain' => 'http://www.rain68.com', //官方网址
    'company_name'   => 'RainSoft', //公司名称
    'original_table_prefix'  => 'rainos_', //默认表前缀
    
    // 安装配置
    'install_table_total' => 511, // 安装时，需执行的sql语句数量
    'update_data_total'   => 500,
//  'view_replace_str'       => [
//	    '__ROOT__'    =>  \think\request::instance()->root(),
//      '__PUBLIC__'  =>  \think\request::instance()->root() . '/public',           
//      '__STATIC__'  =>  \think\request::instance()->root() . '/public/static',
//      '__PLUGS__'   =>  \think\request::instance()->root() . '/public/static/plugs',
//      '__ONEUI__'   =>  \think\request::instance()->root() . '/public/static/oneui',
//      '__CSS__'     =>  \think\request::instance()->root() . '/public/static/install/css',
//      '__JS__'      =>  \think\request::instance()->root() . '/public/static/install/js',
//      '__IMG__'     =>  \think\request::instance()->root() . '/public/static/install/img',
//  ],    
];
