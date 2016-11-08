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
  Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
  Route::resource('rooms', 'RoomsController', ['only' => ['index', 'show']]);
  Route::resource('reservations', 'ReservationsController');

  Route::get('rooms/{id}/reservations', 'ReservationsController@getReservationsByRoom');
  Route::get('users/{id}/reservations', 'ReservationsController@getReservationsByUser');
  Route::get('users/{id}/customers', 'CustomersController@getCustomersByUser');
  Route::get('reservations/{id}/customer', 'CustomersController@getCustomerByReservation');

  Route::get('me', 'UsersController@getAuthenticatedUser');
  Route::get('me/reservations', 'ReservationsController@getReservationsByAuthenticatedUser');
});
