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

Route::get('/','Shop\IndexController@index');

//商城首页
Route::get('index','Shop\IndexController@index');
//商城登录
Route::get('login','Shop\UserController@login');
//商品列表
Route::get('list','Shop\IndexController@goodsList');
//商品详细
Route::get('detail','Shop\IndexController@goodsDetail');
//购物车
Route::get('cart','Shop\IndexController@shoppingCart');
//用户个人信息
Route::get('selfinfo','Shop\UserController@selfInfo');
//用户个人订单
Route::get('order','Shop\UserController@orderForGoods');
//注册
Route::get('register','Shop\UserController@register');
//登陆验证码验证
Route::post('verify','Shop\UserController@verify');
//测试
Route::get('test','Shop\IndexController@test');
//手机号注册
Route::get('telRegister','Shop\UserController@telRegist');
//注册表单提交（手机号/邮箱）
Route::post('register','Shop\UserController@register');
//手机号登录
Route::get('tel_login','Shop\UserController@loginByTel');
//退出登录
Route::get('loginout','Shop\UserController@loginOut');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//后台路由
Route::group(['middleware'=>['power'],'namespace'=>'Admin'],function(){
    //展示后台首页
    Route::get('admin/index','AdminController@index');

    Route::get('admin/loginout','AdminController@loginOut');
    //添加管理员页面
    Route::get('admin/adminadd','AdminController@adminAdd');
    //前台商品管理
    Route::get('admin/homepage/leftmene','AdminController@operationGoods');

    Route::get('admin/curdadmin','AdminController@operationAdmin');
    //管理员添加
    Route::post('admin/adminadd','AdminController@adminAdd');
    //修改管理员
    Route::get('admin/admin/update','AdminController@adminUpdate');
    //提交修改管理员表达
    Route::post('admin/admin/update','AdminController@adminUpdate');
    //删除
    Route::get('admin/admin/del','AdminController@adminDel');
    //角色列表
    Route::get('admin/curdrole','AdminController@roleList');
    //角色修改页面
    Route::get('admin/role/update','AdminController@roleUpdate');
    //角色修改表单提交
    Route::post('admin/role/update','AdminController@roleUpdate');
    //角色添加
    Route::get('admin/roleadd','AdminController@roleAdd');
    //角色添加表单提交
    Route::post('admin/role/roleadd','AdminController@roleAdd');
    //角色删除
    Route::get('admin/role/del','AdminController@roleDel');
    //角色添加权限
    Route::get('admin/roleaddpower','AdminController@roleAddPower');
    //查找角色权限
    Route::get('admin/role/select','AdminController@roleSelectPower');
    //添加权限
    Route::post('admin/role/poweradd','AdminController@roleAddPower');
    //角色添加按钮权限
    Route::get('admin/role/roleaddbuttonpower','AdminController@roleAddButtonPower');
    //角色添加按钮权限表单提交
    Route::post('admin/button/poweradd','AdminController@roleAddButtonPower');
});

//后台登录
Route::get('admin/login','Admin\AdminController@login');
//后台登录提交
Route::post('admin/login','Admin\AdminController@login');
