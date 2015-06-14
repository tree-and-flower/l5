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
Route::get('test', 'TestController@index');
//auth
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
//管理员查看客户订单
Route::get('customer/jingdian/{jingdian?}', 'CustomerController@getJingdian')->where(['jingdian' => '[0-9]+']);
Route::post('customer/delCustomer/{id}', 'CustomerController@postDelCustomer')->where(['id' => '[0-9]+']);
Route::post('customer/verifyCustomer/{id}', 'CustomerController@postVerifyCustomer')->where(['id' => '[0-9]+']);
Route::post('customer/unverifyCustomer/{id}', 'CustomerController@postUnverifyCustomer')->where(['id' => '[0-9]+']);
Route::post('customer/refundCustomer/{id}', 'CustomerController@postRefundCustomer')->where(['id' => '[0-9]+']);
Route::post('customer/unrefundCustomer/{id}', 'CustomerController@postUnrefundCustomer')->where(['id' => '[0-9]+']);
//管理员编辑客户订单
Route::get('customer/edit/{id}', 'CustomerController@getEdit')->where(['id' => '[0-9]+']);
Route::post('customer/edit', 'CustomerController@postEdit');

//景区管理
Route::get('jingdian/{jingdian?}', 'JingdianController@getJingdian')->where(['jingdian' => '[0-9]+']);
Route::post('jingdian/consumeCustomer/{id}', 'JingdianController@postConsumeCustomer')->where(['id' => '[0-9]+']);
Route::post('jingdian/unconsumeCustomer/{id}', 'JingdianController@postUnconsumeCustomer')->where(['id' => '[0-9]+']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
//404
Route::get('404', function()
{
    App::abort(404);
});
