<?php

use Illuminate\Support\Facades\DB;
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

DB::enableQueryLog();

/*
 * ads actions
 */
Route::get('/', 'AdController@index')->name('home');

//Route::get('/detail/{id}', 'AdController@detail')->name('detail');

Route::get('/{ad_slug}-ad{ad_id}.html', 'AdController@detail')
        ->name('ad_detail')
        ->where(['ad_slug' => '.*', 'ad_id' => '\d+']);

Route::get('/publish', 'AdController@getPublish')->name('publish');
Route::post('/publish', 'AdController@postPublish')->name('postPublish');
Route::post('/axgetcarmodels', 'AdController@axgetcarmodels');
Route::get('/publish/activate/{token}', 'AdController@activate');
Route::get('/delete/{token}', 'AdController@delete');

/**
 * user actions
 */
Route::get('/profile', 'UserController@profile')->name('profile');

// Authentication Routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('register/confirm/{token}', 'Auth\AuthController@confirmEmail');

// Password reset link request routes...
Route::get('lostpassword', 'Auth\PasswordController@getEmail');
Route::post('lostpassword', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('reset/{token}', 'Auth\PasswordController@getReset');
Route::post('reset', 'Auth\PasswordController@postReset');

Route::get('/proxy', 'AdController@proxy')->name('proxy');

/**
 * search routes
 */
//category + location + search string
Route::get('/{category_slug}/l-{location_slug}/q-{search_text}', 'AdController@search')
	->name('category_location_search_text')
	->where(['category_slug' => '.*', 'location_slug' => '.*', 'search_text' => '.*']);

//location + search string
Route::get('/l-{location_slug}/q-{search_text}', 'AdController@search')
	->name('location_search_text')
	->where(['location_slug' => '.*', 'search_text' => '.*']);
	
//location
Route::get('/l-{location_slug}', 'AdController@search')
	->name('location_slug')
	->where(['location_slug' => '.*']);

//search string
Route::get('/q-{search_text}', 'AdController@search')
	->name('search_text')
	->where(['search_text' => '.*']);	

//category + location
Route::get('/{category_slug}/l-{location_slug?}', 'AdController@search')
	->name('category_location_slug')
	->where(['category_slug' => '.*', 'location_slug' => '.*']);
	
//category + search string
Route::get('/{category_slug}/q-{search_text}', 'AdController@search')
	->name('category_search_text')
	->where(['category_slug' => '.*', 'search_text' => '.*']);	
	
//category	
Route::get('/{category_slug}', 'AdController@search')
	->name('category_slug')
	->where(['category_slug' => '.*']);








