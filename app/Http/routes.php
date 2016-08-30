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
 * admin routes
 */
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function()
{
	// Controllers Within The "App\Http\Controllers\Admin" Namespace
	Route::get('/admin', 'AdminController@dashboard');
	
	//Locations
	Route::get('/admin/location', 'LocationController@index');
	Route::any('/admin/location/edit/{id?}', 'LocationController@edit');
	Route::any('/admin/location/delete/{id?}', 'LocationController@delete');
	Route::any('/admin/location/import', 'LocationController@import');
	
	//Categories
	Route::get('/admin/category', 'CategoryController@index');
	Route::any('/admin/category/edit/{id?}', 'CategoryController@edit');
	Route::any('/admin/category/delete/{id?}', 'CategoryController@delete');
	Route::any('/admin/category/import', 'CategoryController@import');
	
	//Ads
	Route::get('/admin/ad', 'AdController@index');
	Route::any('/admin/ad/edit/{id?}', 'AdController@edit');
	Route::any('/admin/ad/delete/{id?}', 'AdController@delete');
	Route::any('/admin/ad/axlist', 'AdController@axlist');
	
});
/*
 * end of admin routes
 */

/*
 * ads actions
 */
Route::get('/', 'AdController@index')->name('home');

Route::get('/{ad_slug}-ad{ad_id}.html', 'AdController@detail')
	->name('ad_detail')
	->where(['ad_slug' => '.*', 'ad_id' => '\d+']);

Route::get('/ad/contact/{ad_id}', 'AdController@getAdContact')
	->name('ad_contact')
	->where(['ad_id' => '\d+']);

Route::post('/ad/contact/{ad_id}', 'AdController@postAdContact')
	->name('post_ad_contact')
	->where(['ad_id' => '\d+']);
        
Route::get('/publish', 'AdController@getPublish')->name('publish');
Route::post('/publish', 'AdController@postPublish')->name('postPublish');

Route::post('/axgetcarmodels', 'AdController@axgetcarmodels');
Route::post('/axreportad', 'AdController@axreportad');
Route::post('/axsavetofav', 'AdController@axsavetofav');

Route::get('/publish/activate/{token}', 'AdController@activate');
Route::get('/delete/{token}', 'AdController@delete')->name('delete');

Route::get('/myads', 'AdController@myads')->name('myads')->middleware('auth');
Route::get('/republish/{token}', 'AdController@republish')->name('republish');
Route::get('/ad/edit/{ad_id}', 'AdController@edit')->name('adedit')->where(['ad_id' => '\d+'])->middleware('auth');
Route::post('/ad/edit/{ad_id}', 'AdController@postAdEdit')->name('postAdEdit')->where(['ad_id' => '\d+'])->middleware('auth');
Route::get('/ad/user/{user_id}', 'AdController@userads')->name('userads')->where(['user_id' => '\d+'])->middleware('auth');

Route::get('/proxy', 'AdController@proxy')->name('proxy');

/**
 * user actions
 */
Route::get('/mymail', 'UserController@mymail')->name('mymail')->middleware('auth');
Route::get('/mailview/{hash}/{user_id_from}/{ad_id}', 'UserController@mailview')
	->name('mailview')
	->where(['user_id_from' => '\d+', 'ad_id' => '\d+'])
	->middleware('auth');
	
Route::post('/mailview/{hash}/{user_id_from}/{ad_id}', 'UserController@mailviewsave')
	->name('mailviewsave')
	->where(['user_id_from' => '\d+', 'ad_id' => '\d+'])
	->middleware('auth');
	
Route::get('/maildelete/{mail_id}', 'UserController@maildelete')->name('maildelete')->middleware('auth');

Route::get('/myprofile', 'UserController@myprofile')->name('profile')->middleware('auth');
Route::post('/myprofile', 'UserController@myprofilesave')->name('profilesave')->middleware('auth');

// Authentication Routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout')->middleware('auth');

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



/**
 * search routes
 */
Route::get('/search', 'AdController@search')->name('search');

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
	
	
