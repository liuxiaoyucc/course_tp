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

// 多级路由可以在app配置文件中修改controller_auto_search参数为true, 优先于这里的配置, 但是在这里配置更为灵活
// Route::post('app/v1/article/add','app/v1.article/add');
// Route::get('app/v1/article/:id','app/v1.article/info');

// 使用路由分组实现
Route::group('app/v1/article', function(){
	Route::post('add', 'app/v1.article/add');
	Route::get('info', 'app/v1.article/info');
	Route::get('list', 'app/v1.article/list');
	Route::post('like', 'app/v1.article/like');
});
return [

];
