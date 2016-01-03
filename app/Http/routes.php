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


Route::get('/login', 'UserController@login')->name('login');
Route::get('/register', 'UserController@register')->name('register');
Route::get('/lostpassword', 'UserController@lostpassword')->name('lostpassword');


