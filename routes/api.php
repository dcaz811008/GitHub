<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 連線DB測試
Route::get('/area', 'Api\InfoController@getArea');
// 全家soap訂單建立
Route::get('/Fami', 'Api\InfoController@getFami');
// aftee
Route::get('/aftee', 'Api\InfoController@getAftee');
// aftee
Route::get('/aftee2', 'Api\TestController@getAftee');
// 取得三段式條碼
Route::get('/barcode', 'Api\InfoController@getBarcode');
// 轉成圖檔
Route::get('/barcode2', 'Api\InfoController@getBarcode2');
// 解析soap
Route::post('/soap', 'Api\InfoController@soapTest');
// 手機推播測試
Route::post('/push', 'Api\InfoController@doPush');
// 寄信測試
Route::post('/smdmail', 'Api\InfoController@testMail');

Route::get('/test', 'Api\InfoController@testDB');
// 中介層過濾器
Route::middleware(['needLogin'])
->group(function () {
    Route::post('/soap2', 'Api\InfoController@soapTest2');
});