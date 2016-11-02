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

Route::get('/', 'searchController@index');
Route::post('/search_post', ['as'=>'search.post', 'uses' => 'searchController@post']);

Route::get('/login','loginController@login');
Route::post('login_store',['as'=>'login_store', 'uses' => 'loginController@login_store@login_store']);
//Route::post('login_store',['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);

Route::group(['middleware' => 'auth'], function (){

	Route::get('/consola','universalController@dashboard');

	Route::resource('looper','looperController');
	Route::get('/looper/trash/trash', ['uses' =>'looperController@trash']);
	Route::get('/looper/{id}/inactive', ['uses' =>'looperController@inactive']);
	Route::get('/looper/{id}/untrashed', ['uses' =>'looperController@untrashed']);
	Route::get('/looper/latency/latency', ['uses' =>'looperController@latency']);
	Route::get('/looper/{id}/scan', ['uses' =>'looperController@scan']);
	Route::get('/looper/{id}/scan_exe', ['uses' =>'looperController@scan_exe']);
	Route::get('/looper/{id}/scan_results', ['uses' =>'looperController@scan_results']);
	Route::get('/looper/{id}/class_list', ['uses' =>'looperController@class_list']);
	Route::get('/looper/{id}/tree', ['uses' =>'looperController@tree']);

	Route::resource('domain','domainController');
	Route::get('/domain/trash/trash', ['uses' =>'domainController@trash']);
	Route::get('/domain/{id}/inactive', ['uses' =>'domainController@inactive']);
	Route::get('/domain/{id}/untrashed', ['uses' =>'domainController@untrashed']);
	Route::get('/domain/{id}/enrich', ['uses' =>'domainController@enrich']);

	Route::resource('class','classController');
	Route::post('class.get_list',['as'=>'class.get_list', 'uses' => 'classController@get_list']);
	Route::get('/class/trash/trash', ['uses' =>'classController@trash']);
	Route::get('/class/list_class/{id}', ['uses' =>'classController@list_class']);
	
	Route::get('/class/{id}/inactive', ['uses' =>'classController@inactive']);
	Route::get('/class/{id}/untrashed', ['uses' =>'classController@untrashed']);
	Route::get('/class/{id}/enrich', ['uses' =>'classController@enrich']);

	Route::resource('classification','clasificationController');
});
