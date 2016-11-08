<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Room;
use App\Transformers\ReservationTransformer;


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
    private function getReservations($roomId) {
      $reservations = $roomId ? Room::findOrFail($roomId)->reservations() : Reservation::all();
      return $reservations;
    }

    /**
     * Display a listing of the resource.
     * @param null $id
     * @return \Illuminate\Http\Response
     */
    public function index($roomId = null)
    {
        $reservations = $this->getReservations($roomId);

        // Use count to check if empty, because the get() method in Model always returns an instance of Collection
        if(!count($reservations)) {
          return $this->respondNotFound('Reservation for this room does not exist!');
        }

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
