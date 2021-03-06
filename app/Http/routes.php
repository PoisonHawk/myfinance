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

Route::get('/', [   
    'as' => 'home',
    'uses' => 'IndexController@home',
]);

Route::get('/token', [
    'middleware' => 'auth',
    'as' => 'token',
    'uses' => 'IndexController@token',
]);

Route::get('bill', [
	'as' => 'bill',
	'uses' => 'BillController@index',
]);

Route::resource('bills', 'BillsController');

Route::resource('category', 'CategoryController');

Route::get('operations/{id}/cancel' , 'OperationsController@cancel');
Route::get('operations/getoutcomes' , 'OperationsController@getOutcomes');
Route::resource('operations', 'OperationsController');

Route::resource('transfers', 'TransferController',
                ['except' => ['show', 'edit', 'update']]);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('reportoutcome/{type}', 'ReportOutcome@getReport');

Route::match(['get', 'post'], 'purchase/process/{id}', [
	'uses' => 'PurchasesController@process',
	'as' => 'purchase.process',
		]
	);

Route::resource('purchase', 'PurchasesController');


