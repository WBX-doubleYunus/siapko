<?php

use Illuminate\Support\Facades\Route;

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
// auth
Route::get('/login', 'AuthController@getLogin')->name('login')->middleware('guest');
Route::post('/login', 'AuthController@doLogin')->middleware('guest');
Route::get('/logout', 'AuthController@doLogout')->middleware('auth');

// agenda
Route::get('/', 'AgendaController@index')->name('agenda.index')->middleware('auth');
Route::group(['prefix' => 'agenda', 'middleware' => 'auth'], function() {
    Route::get('/json', 'AgendaController@json')->name('agenda.json');
    Route::put('/status/{agenda}', 'AgendaController@updateStatus')->name('agenda.update-status');
});
Route::resource('agenda', 'AgendaController')->except('index')->middleware('auth');

// riwayat
Route::group(['prefix' => 'riwayat', 'middleware' => 'auth'], function() {
    Route::get('/', 'AgendaController@indexRiwayat')->name('riwayat.index');
});
