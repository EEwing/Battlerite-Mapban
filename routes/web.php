<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['web']], function(){

    Route::get('/', 'HomeController@index');

    Route::get('/create', 'MapBanController@create');
    Route::get('/manage/{mapban}/{token}', 'MapBanController@manage');
    Route::get('/view/{mapban}', 'MapBanController@spectate');
    Route::get('/view/{mapban}/results', 'MapBanController@viewResults');
    Route::get('/view/{mapban}/{token}', 'MapBanController@viewTeam');
    Route::post('/view/{mapban}/{token}/ready', 'MapBanController@readyTeam');
    Route::post('/view/{mapban}/{token}/banMap', 'MapBanController@banMap');

    Route::post('/store', 'MapBanController@store');

});


Route::group(['middleware' => ['web', 'auth.basic']], function(){

    Route::get('/admin', 'AdminController@index');
    Route::post('/admin/storeMap', 'AdminController@storeMap');



});