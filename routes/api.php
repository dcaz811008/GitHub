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

Route::get('/area', 'Api\InfoController@getArea');

Route::get('/Fami', 'Api\InfoController@getFami');

Route::get('/barcode', 'Api\InfoController@getBarcode');

Route::get('/barcode2', 'Api\InfoController@getBarcode2');

Route::post('/soap', 'Api\InfoController@soapTest');

Route::post('/push', 'Api\InfoController@doPush');

Route::post('/smdmail', 'Api\InfoController@testMail');

Route::get('/test', 'Api\InfoController@testDB');

Route::middleware(['needLogin'])
->group(function () {
    Route::post('/soap2', 'Api\InfoController@soapTest2');
});