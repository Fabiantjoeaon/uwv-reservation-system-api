<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Room;
use App\User;
use App\Transformers\ReservationTransformer;
use Illuminate\Support\Facades\Auth;

class ReservationsController extends ApiController
{
    /**
     * @var App\Transformers\ReservationTransformer
     */
    protected $reservationTransformer;

    function __construct(reservationTransformer $reservationTransformer) {
      $this->reservationTransformer = $reservationTransformer;
    }

    /**
     * Get reservations by roomId or none
     * @param  integer $roomID Id of the room resource
     * @return Object of App\Reservation
     */
    public function getReservationsByRoom($roomId) {
      $reservations = Room::findOrFail($roomId)->reservations();

      if(!count($reservations)) {
        return $this->respondNotFound('There are no reservations for this room!');
      }

      return $this->respond([
        'data' => $this->reservationTransformer->transformCollection($reservations->toArray())
      ]);
    }

    /**
     * Get reservations by userId
     * @param  integer $userId of the user resource
     * @return Object of App\User
     */
    public function getReservationsByUser($userId) {
        $reservations = User::findOrFail($userId)->reservations();

        if(!count($reservations)) {
          return $this->respondNotFound('There are no reservations for this user!');
        }

        return $this->respond([
          'data' => $this->reservationTransformer->transformCollection($reservations->toArray())
        ]);
    }

    public function getReservationsByAuthenticatedUser() {
      $userId = Auth::id();
      $reservations = User::findOrFail($userId)->reservations();

      if(!count($reservations)) {
        return $this->respondNotFound('You have no reservations!');
      }

      return $this->respond([
        'data' => $this->reservationTransformer->transformCollection($reservations->toArray())
      ]);
    }

    /**
     * Display a listing of the resource.
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();

        return $this->respond([
          'data' => $this->reservationTransformer->transformCollection($reservations->toArray())
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
        $reservation = Reservation::find($id);
        if(!$reservation) {
          return $this->respondNotFound('Reservation does not exist!');
        }

        return $this->respond([
          'data' => $this->reservationTransformer->transform($reservation)
        ]);
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
