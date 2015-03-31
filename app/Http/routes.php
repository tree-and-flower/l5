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

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
//wechat
Route::any('/wechat', 'WechatController@serve');
//微信
Route::group(array('prefix' => 'weixin'),function()
{
    Route::resource('/','WeixinController');
    Route::get('card',array('uses'=>'WeixinController@card'));
    Route::post('card',array('uses'=>'WeixinController@card'));
});
//404
Route::get('404', function()
{
    App::abort(404);
});
