<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('user', 'UserController');
Route::resource('task', 'TaskController');
Route::post('user/sign_in', 'UserController@sign_in');
Route::post('user/sign_up', 'UserController@sign_up');
Route::post('user/log_off', 'UserController@log_off');
Route::post('task/sort', 'TaskController@sort');
Route::post('task/create', 'TaskController@create');
