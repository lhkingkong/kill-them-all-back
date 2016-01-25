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
Route::resource('admin', 'AdminController');
Route::resource('game', 'GameController');
Route::resource('round', 'RoundController');
Route::resource('fighter', 'FighterController');
Route::resource('fighterClass', 'FighterClassController');
Route::resource('action', 'ActionController');
Route::resource('timeline', 'TimelineController');
Route::post('user/sign_in', 'UserController@sign_in');
Route::post('user/sign_up', 'UserController@sign_up');
Route::post('user/log_off', 'UserController@log_off');
Route::post('admin/sign_in', 'AdminController@sign_in');
Route::post('task/sort', 'TaskController@sort');
Route::post('task/create', 'TaskController@create');
Route::post('game/create', 'GameController@create');
Route::post('game/end_game', 'GameController@end_game');
Route::post('round/close_round', 'RoundController@close_round');
Route::post('round/next_round', 'RoundController@next_round');
Route::post('fighter/create', 'FighterController@create');
Route::post('fighter/get_all', 'FighterController@get_all');
Route::post('fighter/get_info', 'FighterController@get_info');
Route::post('fighter/kill', 'FighterController@kill_fighter');
Route::post('fighter/revive', 'FighterController@revive_fighter');
Route::post('action/create', 'ActionController@create');

