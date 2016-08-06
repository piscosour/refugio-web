<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',array(
	'as' 	=> 'home.getIndex',
	'uses'	=> 'HomeController@getIndex'
));

Route::get('/refugios',array(
	'as' 	=> 'home.getRefuges',
	'uses'	=> 'HomeController@getRefuges'
));