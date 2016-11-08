<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function() {
  return 'Welcome to API';
});

/* API Version 1 */
Route::group(['prefix' => 'v1', 'middleware' => 'auth.basic'], function() {
  Route::resource('rooms', 'RoomsController');
});
