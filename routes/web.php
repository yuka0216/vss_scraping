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

Route::group(['prefix' => 'admin/vessel'], function() {
    // Route::get('/', 'Admin\VssController@add');
    Route::get('/index', 'Admin\VssController@index');
    Route::get('/tokyo','Admin\VssController@tokyo');
    Route::get('/yokohama','Admin\VssController@yokohama');
    Route::get('/ohsaka','Admin\VssController@ohsaka');
    Route::get('/kobe','Admin\VssController@kobe');
});

