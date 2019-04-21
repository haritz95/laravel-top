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
