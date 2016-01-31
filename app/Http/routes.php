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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AdController@index')->name('home');

Route::get('/search/{params?}', 'AdController@search')
	->name('search')->where('params', '.*')
	->middleware('segment_fix');
	
	
Route::get('/detail/{id}', 'AdController@detail')->name('detail');
Route::match(['get', 'post'], '/publish', 'AdController@publish')->name('publish');


// Authentication Routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('lostpassword', 'Auth\PasswordController@getEmail');
Route::post('lostpassword', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('reset/{token}', 'Auth\PasswordController@getReset');
Route::post('reset', 'Auth\PasswordController@postReset');

Route::get('/{slug}', 'AdController@proxy')->name('proxy')->where('slug', '.*');







