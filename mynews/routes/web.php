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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::post('news/create','Admin\NewsController@create')->middleware('auth'); # 追記
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
    Route::post('profile/edit', 'Admin\ProfileController@update')->middleware('auth');
    Route::get('news', 'Admin\NewsController@index')->middleware('auth'); //追記（＃１６）
    Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth'); //追記（＃１７）
    Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth'); //追記（＃１７）
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth');//追記（＃１７）
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
