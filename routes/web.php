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
Route::get('/mandate', 'MandatController@index')->name('mandat');
Route::get('/mandate/{n}', 'MandatController@index')->where('n', '[0-9]+');
Route::get('/calendar', 'CalendarController@index')->name('calendar');