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

use think\Route;

//后台接口域名路由 adminapi
Route::domain('adminapi', function(){
    //adminapi模块首页路由
    Route::get('/', 'adminapi/index/index');
    //定义 域名下的其他路由
    //比如 以后定义路由 get请求  http://adminapi.pyg.com/goods  访问到 adminapi模块Goods控制器index方法
    //Route::resource('goods', 'adminapi/goods');
    //获取验证码接口
    Route::get('captcha/:id', "\\think\\captcha\\CaptchaController@index");
    Route::get('captcha', 'adminapi/login/captcha');
    //登录接口
    Route::post('login', 'adminapi/login/login');
    //退出接口
    Route::get('logout', 'adminapi/login/logout');
    //权限接口
    Route::resource('auths', 'adminapi/auth', [], ['id'=>'\d+']);
    //查询菜单权限的接口
    Route::get('nav', 'adminapi/auth/nav');
    //角色接口
    Route::resource('roles', 'adminapi/role', [], ['id'=>'\d+']);
    //管理员接口
    Route::resource('admins', 'adminapi/admin', [], ['id'=>'\d+']);
    //商品分类接口
    Route::resource('categorys', 'adminapi/category', [], ['id'=>'\d+']);
    //单图片上传接口
    Route::post('logo', 'adminapi/upload/logo');
    //多图片上传接口
    Route::post('images', 'adminapi/upload/images');
    //商品品牌接口
    Route::resource('brands', 'adminapi/brand', [], ['id'=>'\d+']);
    //商品模型（类型）接口
    Route::resource('types', 'adminapi/type', [], ['id'=>'\d+']);
    //商品接口
    Route::resource('goods', 'adminapi/goods', [], ['id'=>'\d+']);
    
    
    
});
