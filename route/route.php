<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});
Route::get('login','index/User/login');
Route::get('register','index/User/register');
Route::get('quit','index/User/quit');
Route::get('page/:id','index/Page/index');
Route::get('page/:name','index/Page/index');
Route::get('hello/:name', 'index/hello');

foreach (glob(APP_PATH . '*/route.php') as $route_file){
	include $route_file;
}

return [

];
