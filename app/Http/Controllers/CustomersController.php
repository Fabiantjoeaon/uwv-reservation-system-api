<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Reservation;
use App\Transformers\CustomerTransformer;

class CustomersController extends ApiController
{
    /**
     * @var App\Transformers\ReservationTransformer;
     */
    protected $customerTransformer;

    function __construct(CustomerTransformer $customerTransformer) {
        $this->customerTransformer = $customerTransformer;
    }

    function getCustomersByUser($userId) {
      $customers = User::findOrFail($userId)->customers();

      if(!count($customers)) {
        return $this->respondNotFound('There are no customers for this user!');
      }

      return $this->respond([
        'data' => $this->customerTransformer->transformCollection($customers->toArray())
      ]);
    }

    function getCustomerByReservation($reservationId) {
      $customer = Reservation::findOrFail($reservationId)->customer();

      if(!count($customer)) {
        return $this->respondNotFound('There is no customer for this reservation!');
      }

      return $this->respond([
        'data' => $this->customerTransformer->transform($customer)
      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
