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
