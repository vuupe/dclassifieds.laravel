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
Route::get('/search', 'AdController@search')->name('search');
Route::get('/detail/{id}', 'AdController@detail')->name('detail');


Route::get('/login', 'UserController@login')->name('login');
Route::get('/register', 'UserController@register')->name('register');
Route::get('/lostpassword', 'UserController@lostpassword')->name('lostpassword');


