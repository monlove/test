<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
namespace think;
//字符集为UTF8
header("Content-type: text/html; charset=utf-8");
if (version_compare(PHP_VERSION, '7', '<')) {
    die('PHP版本过低，最少需要PHP7.x，请升级PHP版本！');
}

// 定义应用目录
define('APP_PATH',  __DIR__.'/apps/');
// 检查是否安装

// 加载框架引导文件
require './thinkphp/base.php';
// 支持事先使用静态方法设置Request对象和Config对象
if(!is_file('./public/data/install.lock')){
    Container::get('app', [APP_PATH])->bind('install')->run()->send();
}else{
	Container::get('app', [APP_PATH])->run()->send();
}
// 执行应用并响应



