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

Route::get('/', function (Request $request) {
  $data = array('user1' => array('name' => 'Steve', 'country' => 'Netherlands'), 'user2' => array('name' => 'Fabian', 'country' => 'England'));
  return Response::json($data);
});
