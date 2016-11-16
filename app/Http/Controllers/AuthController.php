<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends ApiController {
  public function authenticate(Request $request) {
    $credentials = $request->only('email', 'password');

    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return $this->respondUnauthorized();
      }
    } catch (JWTException $e) {
        return $this->respondInternalError('Could not create token!');
    }

    return $this->respond(compact('token'));
  }
}
