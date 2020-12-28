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

Route::get('/', function () {
    return view('welcome');
});

// 左右移動
Route::get('/test', function () {
    return view('test');
});
// 上下移動
Route::get('/test2', function () {
    return view('test2');
});

// 監聽移動
Route::get('/test3', function () {
    return view('test3');
});

// load
Route::get('/test4', function () {
    return view('test4');
});
// load
Route::get('/test5', function () {
    return view('test5');
});


Route::get('/home', function () {
    return view('/site/layouts/home');
});

Route::get('/editorWeb', 'Adm\UserController@active');

# vendor web
Route::domain(env('APP_DOMAIN_VENDOR'))->group(function()
{
    # 首頁
    Route::get('/test', 'Web\WebController@index');
});

