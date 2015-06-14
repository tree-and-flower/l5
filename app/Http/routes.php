<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */
//Test
Route::get('test', ['uses'=>'TestController@index']);
//auth
Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index');
});
//管理员查看客户订单
Route::group(['prefix' => 'customer', 'middleware' => 'auth'], function(){
    Route::get('jingdian/{jingdian?}', 'CustomerController@getJingdian')->where(['jingdian' => '[0-9]+']);
    Route::post('delCustomer/{id}', 'CustomerController@postDelCustomer')->where(['id' => '[0-9]+']);
    Route::post('verifyCustomer/{id}', 'CustomerController@postVerifyCustomer')->where(['id' => '[0-9]+']);
    Route::post('unverifyCustomer/{id}', 'CustomerController@postUnverifyCustomer')->where(['id' => '[0-9]+']);
    Route::post('refundCustomer/{id}', 'CustomerController@postRefundCustomer')->where(['id' => '[0-9]+']);
    Route::post('unrefundCustomer/{id}', 'CustomerController@postUnrefundCustomer')->where(['id' => '[0-9]+']);
    //管理员编辑客户订单
    Route::get('edit/{id}', 'CustomerController@getEdit')->where(['id' => '[0-9]+']);
    Route::post('edit', 'CustomerController@postEdit');
});

//景区管理
Route::group(['prefix' => 'jingdian', 'middleware' => 'auth'], function(){
    Route::get('/{jingdian?}', 'JingdianController@getJingdian')->where(['jingdian' => '[0-9]+']);
    Route::post('consumeCustomer/{id}', 'JingdianController@postConsumeCustomer')->where(['id' => '[0-9]+']);
    Route::post('unconsumeCustomer/{id}', 'JingdianController@postUnconsumeCustomer')->where(['id' => '[0-9]+']);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
//404
Route::get('404', function()
{
    App::abort(404);
});
