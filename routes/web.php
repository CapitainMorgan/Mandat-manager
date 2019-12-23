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
Route::middleware('auth')->group(function () {

Route::get('/', 'MandatController@index')->name('home');
Route::get('/mandate', 'MandatController@index')->name('mandat');
Route::get('/price', 'PriceController@index')->name('price');
Route::get('/mandate/{mandate_id}', 'MandatController@show')->where('mandate_id', '[0-9]+');
Route::get('/mandate/create', 'MandatController@create')->name('mandat_create');
Route::get('/mandate/modify/{mandate_id}', 'MandatController@modify')->where('mandate_id', '[0-9]+');
Route::post('/mandate/store', 'MandatController@store')->name('mandat_store');
Route::post('/mandate/update', 'MandatController@update')->name('mandat_update');
Route::get('/price/all', 'MandatController@getPrice')->name('get_prices');
Route::get('/calendar', 'CalendarController@index')->name('calendar');
Route::get('/mandate/share/{user_id}/{mandate_id}', 'MandatController@share')->where('user_id','[0-9]+')->where('mandate_id','[0-9]+');
Route::get('/events', "CalendarController@events");
Route::post('/worktime/new', "MandatController@addWorktime");
Route::get('/worktime/{id}', "MandatController@getWorkTime");
Route::get('/worktime/edit/{worktime_id}', "MandatController@updateWorktime");
Route::post('/worktime/edit', "MandatController@editWorktime");
Route::get('/worktime/delete/{id}', "MandatController@deleteWorktime");
Route::get('/getAllUsersNotShared/{mandate_id}',"MandatController@getAllUsersNotShared")->where('mandate_id', '[0-9]+');
Route::get('/mandate/{mandate_id}/share/{user_id}',"MandatController@share")->where('mandate_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::get('/getAllMandate',"MandatController@getAllMandate");
Route::get('/getFees/{worktime_id}',"MandatController@getFees")->where('worktime_id', '[0-9]+');
Route::get('/mandate/delete/{mandate_id}',"MandatController@deleteMandate")->where("mandate_id", '[0-9]+');
Route::post('/price/new', "MandatController@createPrice");
Route::post('/price/edit', "PriceController@editPrice");
Route::post('/bill/{mandate_id}', "MandatController@createBillFiles")->where("mandate_id", '[0-9]+');
});