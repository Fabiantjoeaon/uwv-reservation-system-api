<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Middleware\GetUserFromToken;

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
Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function() {

  Route::post('/login', 'AuthController@authenticate');

  Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function() {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'store']]);
    Route::resource('rooms', 'RoomsController', ['only' => ['index', 'show']]);
    Route::resource('reservations', 'ReservationsController');
    Route::resource('customers', 'CustomersController');

    Route::get('rooms/{id}/reservations', 'ReservationsController@getReservationsByRoom');
    Route::get('users/{id}/reservations', 'ReservationsController@getReservationsByUser');
    Route::get('users/{id}/customers', 'CustomersController@getCustomersByUser');
    Route::get('reservations/{id}/customer', 'CustomersController@getCustomerByReservation');

    Route::get('me', 'UsersController@getAuthenticatedUser');
    Route::get('me/reservations', 'ReservationsController@getReservationsByAuthenticatedUser');
    Route::get('me/customers', 'CustomersController@getCustomersByAuthenticatedUser');
  });
});
