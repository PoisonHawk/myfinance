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
    'middleware' => 'auth',
    'as' => 'home',
    'uses' => 'IndexController@home',
]);


Route::resource('bills', 'BillsController');

Route::get('category/income', 'CategoryController@income');
Route::get('category/outcome', 'CategoryController@outcome');

Route::resource('category', 'CategoryController');

Route::get('operations/{id}/cancel' , 'OperationsController@cancel');
Route::resource('operations', 'OperationsController');

Route::resource('transfers', 'TransferController');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

