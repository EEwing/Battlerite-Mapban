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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/mapbans/{mapBanSession}', 'HomeController@enterSession');
Route::get('/mapbans/{mapban}/view', 'HomeController@viewSession');
Route::get('/mapbans/{mapban}/results', 'HomeController@viewResults');
Route::post('/mapbans/{mapBanSession}/chooseTeam', 'HomeController@chooseTeam');
Route::post('/mapbans/{mapBanSession}/banMap', 'HomeController@banMap');

Route::group(['middleware' => ['web', 'auth']], function(){
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin/storeMap', 'AdminController@storeMap');

    Route::post('/storeMapBanSession', 'HomeController@storeSession');

    Route::get('/create', 'HomeController@createSession');
});
