<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Room;
use App\Reservation;
use App\Transformers\RoomTransformer;

class RoomsController extends ApiController
{
    /**
     * @var App\Transformers\RoomTransformer
     */
    protected $roomTransformer;

    function __construct(RoomTransformer $roomTransformer) {
      $this->roomTransformer = $roomTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        return $this->respond([
          'data' => $this->roomTransformer->transformCollection($rooms->toArray())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);

        if(!$room) {
          return $this->respondNotFound('Room does not exist!');
        }

        return $this->respond([
          'data' => $this->roomTransformer->transform($room)
        ]);
    }
}
