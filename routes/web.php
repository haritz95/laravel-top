<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('sites', 'SitesController');
Route::get('/vote/{id}', 'SitesController@vote')->name('sites');
Route::post('/vote/add/{id}', 'SitesController@storeVote');
Route::post('/site/store', 'SitesController@store');
Route::post('/visit/add', 'SitesController@storeVisit')->name('visit');
Route::get('/preview_ad/{id}', 'SitesController@previewAd');
/*Route::get('/dashboard', 'SitesController@dashboard')->name('dashboard');*/
Route::get('/dashboard/my_sites', 'SitesController@dashboard')->name('dashboard');
Route::get('/dashboard/my_ads', 'SitesController@myAds')->name('my_ads');
Route::get('/dashboard/my_account', 'SitesController@myAccount')->name('my_account');
Route::post('/dashboard/account/password_update', 'HomeController@postCredentials');
Route::get('/dashboard/ad/create', 'SitesController@adCreate')->name('ad_create');
Route::post('/dashboard/create_ad', 'SitesController@storeAd')->name('store_ad');
Route::post('/ad/{id}/click', 'SitesController@clickAd');
Route::delete('/ad/{id}', 'SitesController@destroyAd');
Route::get('/ad/{id}', 'SitesController@editAd');
Route::get('/buy/{id}', 'PaymentController@buyAd');
Route::patch('/ad/update/{id}', 'SitesController@updateAd');
Route::delete('/category/{id}', 'SitesController@destroyCategory');
Route::post('/category/update/{id}', 'SitesController@updateCategory');
Route::post('/category/check/', 'SitesController@checkCategory');


Route::get('/admin/dashboard', 'AdminController@index')->name('admin');
Route::get('/admin/users', 'AdminController@users')->name('users');
Route::get('/admin/ads', 'AdminController@ads')->name('ads');
Route::post('/ad/{id}/activate', 'AdminController@changeStatusAd')->name('activatead');
Route::patch('/admin/status/{id}', 'AdminController@changeStatus')->name('status');
Route::post('/user/{id}/ban', 'AdminController@banUser');
Route::post('/user/{id}/unban', 'AdminController@unbanUser')->name('unban');
Route::post('/user/info/{id}', 'AdminController@userInfo')->name('userinfo');
Route::delete('/user/{id}', 'AdminController@destroyUser');
Route::post('/user/', 'AdminController@createUser')->name('createuser');
Route::post('/user/emailcheck', 'AdminController@checkEmail');
Route::post('/user/{id}/info', 'AdminController@user');
Route::post('/user/{id}', 'AdminController@userUpdate');
Route::get('/admin/sites/categories', 'SitesController@categories');
Route::post('/admin/category/create', 'SitesController@createCategory')->name('create_category');
Route::get('/admin/premium', 'SitesController@premium');
Route::post('/admin/premium/create', 'SitesController@createPremium')->name('create_premium');


Route::get('/dashboard/premium', 'SitesController@editAd');
// route for view/blade file
Route::get('/dashboard/premium', array('as' => 'paywithpaypal','uses' => 'PaymentController@payWithPaypal',));
// route for post request
Route::post('paypal', array('as' => 'paypal','uses' => 'PaymentController@postPaymentWithpaypal',));
// route for check status responce premium pay
Route::get('paypal', array('as' => 'statusPremium','uses' => 'PaymentController@getPaymentStatusPremium',));
// route for check status responce ad pay
Route::get('paypal/ad/{id}', 'PaymentController@getPaymentStatusAd');
//Route::get('paypal/{id}', 'PaymentController@getPaymentStatusAd');