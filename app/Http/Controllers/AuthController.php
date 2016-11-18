<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class AuthController extends ApiController {
  /**
   * [authenticate description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function authenticate(Request $request) {
    $credentials = $request->only('email', 'password');
    $data = $request->all();
    dd($request->all());
    $user = User::where('email', Input::get('email'))->first();

    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return $this->respondUnauthorized();
      }
    } catch (JWTException $e) {
        return $this->respondInternalError('Could not create token!');
    }
    // dd()
    return $this->respond([
      'token' => compact('token'),
      'user' => $user]);
  }

  /**
   * [logout description]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function logout(Request $request) {
    $this->validate($request, [
        'token' => 'required'
    ]);

    JWTAuth::invalidate($request->input('token'));
  }
}
