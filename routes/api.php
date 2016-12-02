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
  return view('welcome');
});

/* API Version 1 */
// TODO: LIMIT MIDDLEWARE: http://nathanmac.com/2015/09/12/simple-api-rate-limit-laravel-middleware/
Route::group(['prefix' => 'v1', 'middleware' => ['cors', 'https', 'rate-limit']], function() {

  Route::get('/test', function () {
    $token = JWTAuth::parseToken();

    return JWTAuth::parseToken()->authenticate();
  });

  Route::get('/', function() {
    return view('welcome');
  });

  Route::post('/login', 'AuthController@authenticate');

  Route::group(['middleware' => ['before'=>'jwt.auth','after'=>'jwt.refresh']], function() {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'store']]);
    Route::resource('rooms', 'RoomsController', ['only' => ['index', 'show']]);
    Route::resource('reservations', 'ReservationsController');
    Route::resource('customers', 'CustomersController');

    Route::get('reservations/{id}/user', 'UsersController@getUserByReservation');
    Route::get('reservations/date/{date}', 'ReservationsController@getReservationsByDate');
    Route::get('rooms/{id}/reservations', 'ReservationsController@getReservationsByRoom');
    Route::get('rooms/{id}/active-reservation', 'ReservationsController@getReservedRoomData');
    Route::get('users/{id}/reservations', 'ReservationsController@getReservationsByUser');
    Route::get('users/{id}/customers', 'CustomersController@getCustomersByUser');
    Route::get('reservations/{id}/customer', 'CustomersController@getCustomerByReservation');

    Route::get('me', 'UsersController@getAuthenticatedUser');
    Route::get('me/reservations', 'ReservationsController@getReservationsByAuthenticatedUser');
    Route::get('me/customers', 'CustomersController@getCustomersByAuthenticatedUser');
  });
});
