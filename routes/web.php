<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/android/locations', "AndroidController@locations");
Route::get('/android/zones', "AndroidController@zones");
Route::get('/android/comments', "AndroidController@comments");

Route::post('/android/locations', "AndroidController@storeLocation");
Route::post('/android/comments', "AndroidController@storeComment");
Route::post('/android/messages', "AndroidController@storeMessage");

Route::get('/android/token', "AndroidController@token");

//Route::get('/android/users', "AndroidController@users");