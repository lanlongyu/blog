<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return redirect('/login');
}
);*/

//注册页面
Route::get('/register', 'RegisterController@index');
//注册行为
Route::post('register', 'RegisterController@register');
//登录页面
Route::get('/login', 'LoginController@index')->name('login');
//注册行为
Route::post('/login', 'LoginController@login');


Route::group(['middleware' => 'auth'], function () {
    //搜索页面
    Route::get('/posts/search', 'PostController@search');
    //登出行为
    Route::get('/logout', 'LoginController@logout');
    //个人设置页面
    Route::get('/user/me/setting', 'UserController@setting');
    //个人设置操作
    Route::post('/user/me/setting', 'UserController@settingStore');
    //文章图片上传
    Route::post('/posts/image/upload', 'PostController@imageUpload');
    //文章资源
    Route::resource('posts', 'PostController');
    //提交评论
    Route::post('/posts/{post}/comment', 'PostController@comment');
    //赞
    Route::get('/posts/{post}/zan', 'PostController@zan');
    //取消赞
    Route::get('/posts/{post}/unzan', 'PostController@unzan');

    //个人中心
    Route::get('/user/{user}', 'UserController@show');
    Route::post('/user/{user}/fan', 'UserController@fan');
    Route::post('/user/{user}/unfan', 'UserController@unfan');

    //专题详情页
    Route::get('/topic/{topic}', 'TopicController@show');
    //投稿
    Route::post('/topic/{topic}/submit', 'TopicController@submit');
    //通知
    Route::get('/notices', 'NoticeController@index');
}
);






