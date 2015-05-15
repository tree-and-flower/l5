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
Route::get('jingdian/{jingdian?}', 'JingdianController@getJingdian')->where(['jingdian' => '[0-9]+']);
Route::post('jingdian/delCustomer/{id}', 'JingdianController@postDelCustomer')->where(['id' => '[0-9]+']);
Route::post('jingdian/verifyCustomer/{id}', 'JingdianController@postVerifyCustomer')->where(['id' => '[0-9]+']);
Route::post('jingdian/unverifyCustomer/{id}', 'JingdianController@postUnverifyCustomer')->where(['id' => '[0-9]+']);
Route::post('jingdian/refundCustomer/{id}', 'JingdianController@postRefundCustomer')->where(['id' => '[0-9]+']);
Route::post('jingdian/unrefundCustomer/{id}', 'JingdianController@postUnrefundCustomer')->where(['id' => '[0-9]+']);
//no need auth
Route::get('book/{jingdian?}/{shangjia?}', 'BookController@getBook')->where(['jingdian' => '[0-9]+', 'shangjia' => '[0-9]+']);
Route::post('book', 'BookController@postBook');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
//微信
Route::group(array('prefix' => 'wechat'),function()
{
    Route::any('/', 'WechatController@serve');
    Route::get('/setMenu', 'WechatController@setMenu');
});
//404
Route::get('404', function()
{
    App::abort(404);
});
