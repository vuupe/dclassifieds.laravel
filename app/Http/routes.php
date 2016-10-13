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
    Route::get('/admin/ad/edit/{id}', 'AdController@edit');
    Route::post('/admin/ad/save/{id?}', 'AdController@save');
    Route::any('/admin/ad/delete/{id?}', 'AdController@delete');
    Route::get('/admin/ad/deletemainimg/{id}', 'AdController@deletemainimg');
    Route::get('/admin/ad/deleteimg/{id}/{ad_id}', 'AdController@deleteimg');

    //Users
    Route::get('/admin/user', 'UserController@index');
    Route::any('/admin/user/edit/{id?}', 'UserController@edit');
    Route::any('/admin/user/delete/{id?}', 'UserController@delete');
    Route::any('/admin/user/deleteavatar/{id?}', 'UserController@deleteavatar');

    //Ad Types
    Route::get('/admin/adtype', 'AdTypeController@index');
    Route::any('/admin/adtype/edit/{id?}', 'AdTypeController@edit');
    Route::any('/admin/adtype/delete/{id?}', 'AdTypeController@delete');

    //Ad Conditions
    Route::get('/admin/adcondition', 'AdConditionController@index');
    Route::any('/admin/adcondition/edit/{id?}', 'AdConditionController@edit');
    Route::any('/admin/adcondition/delete/{id?}', 'AdConditionController@delete');

    //Estate Construction Types
    Route::get('/admin/estateconstruction', 'EstateConstructionController@index');
    Route::any('/admin/estateconstruction/edit/{id?}', 'EstateConstructionController@edit');
    Route::any('/admin/estateconstruction/delete/{id?}', 'EstateConstructionController@delete');

    //Estate Furnishing Types
    Route::get('/admin/estatefurnishing', 'EstateFurnishingController@index');
    Route::any('/admin/estatefurnishing/edit/{id?}', 'EstateFurnishingController@edit');
    Route::any('/admin/estatefurnishing/delete/{id?}', 'EstateFurnishingController@delete');

    //Estate Heating Types
    Route::get('/admin/estateheating', 'EstateHeatingController@index');
    Route::any('/admin/estateheating/edit/{id?}', 'EstateHeatingController@edit');
    Route::any('/admin/estateheating/delete/{id?}', 'EstateHeatingController@delete');

    //Estate Types
    Route::get('/admin/estatetype', 'EstateTypeController@index');
    Route::any('/admin/estatetype/edit/{id?}', 'EstateTypeController@edit');
    Route::any('/admin/estatetype/delete/{id?}', 'EstateTypeController@delete');

    //Car Brands
    Route::get('/admin/carbrand', 'CarBrandController@index');
    Route::any('/admin/carbrand/edit/{id?}', 'CarBrandController@edit');
    Route::any('/admin/carbrand/delete/{id?}', 'CarBrandController@delete');
    Route::any('/admin/carbrand/import', 'CarBrandController@import');

    //Car Models
    Route::get('/admin/carmodel', 'CarModelController@index');
    Route::any('/admin/carmodel/edit/{id?}', 'CarModelController@edit');
    Route::any('/admin/carmodel/delete/{id?}', 'CarModelController@delete');
    Route::any('/admin/carmodel/import', 'CarModelController@import');

    //Car Conditions
    Route::get('/admin/carcondition', 'CarConditionController@index');
    Route::any('/admin/carcondition/edit/{id?}', 'CarConditionController@edit');
    Route::any('/admin/carcondition/delete/{id?}', 'CarConditionController@delete');

    //Car Engines
    Route::get('/admin/carengine', 'CarEngineController@index');
    Route::any('/admin/carengine/edit/{id?}', 'CarEngineController@edit');
    Route::any('/admin/carengine/delete/{id?}', 'CarEngineController@delete');

    //Car Modifications
    Route::get('/admin/carmodification', 'CarModificationController@index');
    Route::any('/admin/carmodification/edit/{id?}', 'CarModificationController@edit');
    Route::any('/admin/carmodification/delete/{id?}', 'CarModificationController@delete');

    //Car Transmissions
    Route::get('/admin/cartransmission', 'CarTransmissionController@index');
    Route::any('/admin/cartransmission/edit/{id?}', 'CarTransmissionController@edit');
    Route::any('/admin/cartransmission/delete/{id?}', 'CarTransmissionController@delete');

    //Banners
    Route::get('/admin/banner', 'BannerController@index');
    Route::any('/admin/banner/edit/{id?}', 'BannerController@edit');
    Route::any('/admin/banner/delete/{id?}', 'BannerController@delete');

    //Settings
    Route::get('/admin/settings', 'SettingsController@index');
    Route::any('/admin/settings/edit/{id?}', 'SettingsController@edit');

    //Pages
    Route::get('/admin/page', 'PageController@index');
    Route::any('/admin/page/edit/{id?}', 'PageController@edit');
    Route::any('/admin/page/delete/{id?}', 'PageController@delete');

    //Reports
    Route::get('/admin/report', 'ReportController@index');
    Route::any('/admin/report/delete/{id?}', 'ReportController@delete');

    //Wallet
    Route::get('/admin/wallet', 'WalletController@index');
    Route::any('/admin/wallet/edit/{id?}', 'WalletController@edit');
    Route::any('/admin/wallet/delete/{id?}', 'WalletController@delete');

    //Mail
    Route::get('/admin/mail', 'MailController@index');
    Route::any('/admin/mail/edit/{id?}', 'MailController@edit');
    Route::any('/admin/mail/delete/{id?}', 'MailController@delete');

    //IP Ban
    Route::get('/admin/ipban', 'IpBanController@index');
    Route::any('/admin/ipban/edit/{id?}', 'IpBanController@edit');
    Route::any('/admin/ipban/delete/{id?}', 'IpBanController@delete');

    //Mail Ban
    Route::get('/admin/mailban', 'MailBanController@index');
    Route::any('/admin/mailban/edit/{id?}', 'MailBanController@edit');
    Route::any('/admin/mailban/delete/{id?}', 'MailBanController@delete');

    //Payment Options
    Route::get('/admin/pay', 'PayController@index');
    Route::any('/admin/pay/edit/{id}', 'PayController@edit');
});
/*
 * end of admin routes
 */

/**
 * common
 */
Route::get('/ban', 'BanController@index')->name('ban');

/**
 * Payment
 */
//mobio sms
Route::get('/mobiopay', 'MobioPayController@index')->name('mobiopay');

//fortumo sms
Route::get('/fortumopay', 'FortumoPayController@index')->name('fortumopay');

//paypal standard
Route::get('/paypalpay/{paytype}', 'PaypalPayController@index')->name('paypalpay');
Route::post('/paypalcallback', 'PaypalPayController@paypalcallback')->name('paypalcallback');
Route::get('/paypalsuccess', 'PaypalPayController@paypalsuccess')->name('paypalsuccess');

//stripe
Route::get('/stripepay/{paytype}', 'StripePayController@index')->name('stripepay');
Route::post('/stripe/{paytype}', 'StripePayController@stripe')->name('stripe');


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

//Custom pages
Route::get('p/{page_slug}', 'PageController@index');

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


