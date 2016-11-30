<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Room;
use App\User;
use App\Transformers\ReservationTransformer;
use Illuminate\Support\Facades\Auth;
use DB;

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
     * [getReservedRoomData description]
     * @param  [type] $roomId [description]
     * @return [type]         [description]
     */
    public function getReservedRoomData($roomId) {
      $reservation = DB::table('reservations')
        ->where('is_active_now', '=', 1)
        ->where('room_id', '=', $roomId)
        ->get();

      if(!$reservation) {
        return $this->respondNotFound('There is no active reservation for this room!');
      }

      //Using transformer doesnt work on stdClass instance ? (Which DB::table and statement returns)
      return $this->respond([
        'data' => $reservation
      ]);
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
     * [getReservationsByDate description]
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public function getReservationsByDate($date) {
       $reservations = Reservation::where('start_date_time', 'LIKE', "%$date%")->get();

       if(!count($reservations)) {
         return $this->respondNotFound('There are no reservations for this date!');
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

    /**
     * [getReservationsByAuthenticatedUser description]
     * @return [type] [description]
     */
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
