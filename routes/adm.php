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

# for 自己後臺管理
# env('APP_URL')/adm

# 登入流程
// Route::get('/login', 'Adm\UserController@login');
// Route::post('/login', 'Adm\UserController@loginSubmit');
Route::get('/login', 'Adm\UserController@login');
Route::post('/login', 'Adm\UserController@loginSubmit');

# 使用 middleware 處理 是否 需要登入， needLogin 註冊於 app/Http/Kernel.php
Route::middleware(['needLogin'])
->group(function () {
    # 主畫面
    Route::get('/', 'Adm\UserController@index');
    
});
Route::get('/postMessage', 'Adm\UserController@postMessage');

