<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersController extends ApiController
{
    /**
     * [getAuthenticatedUser description]
     * @return [type] [description]
     */
    public function getAuthenticatedUser() {
      $user = User::findOrFail(Auth::id());

      return $this->respond([
        'data' => $user
      ]);
    }

    /**
     * [getUserByReservation description]
     * @param  [type] $reservationId [description]
     * @return [type]                [description]
     */
    public function getUserByReservation($reservationId) {
      $user = Reservation::findOrFail($reservationId)->user();

      if(!count($user)) {
        return $this->respondNotFound('There is no user for this reservation!');
      }

      return $this->respond([
        'data' => $user
      ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->respond([
          'data' => $users
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
