<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Reservation;
use App\Transformers\CustomerTransformer;
use Illuminate\Support\Facades\Auth;

class CustomersController extends ApiController
{
    /**
     * @var App\Transformers\ReservationTransformer;
     */
    protected $customerTransformer;

    function __construct(CustomerTransformer $customerTransformer) {
        $this->customerTransformer = $customerTransformer;
    }

    /**
     * Retrieve customers by user
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
    public function getCustomersByUser($userId) {
      $customers = User::findOrFail($userId)->customers();

      if(!count($customers)) {
        return $this->respondNotFound('There are no customers for this user!');
      }

      return $this->respond([
        'data' => $this->customerTransformer->transformCollection($customers->toArray())
      ]);
    }

    /**
     * [getCustomersByAuthenticatedUser description]
     * @return [type] [description]
     */
    public function getCustomersByAuthenticatedUser() {
      $userId = Auth::id();
      $customers = User::findOrFail($userId)->customers();

      if(!count($customers)) {
        return $this->respondNotFound('You have no customers!');
      }

      return $this->respond([
        'data' => $this->customerTransformer->transformCollection($customers->toArray())
      ]);
    }

    /**
     * Retrieve customers by reservation
     * @param  [integer] $reservationId
     * @return response
     */
    public function getCustomerByReservation($reservationId) {
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
        $customers = Customer::all();

        return $this->respond([
          'data' => $this->customerTransformer->transformCollection($customers->toArray())
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
      $input = $request->all();
      $customer = new Customer;

      if($customer->validate($input)) {
        $userId = Auth::user()->id;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->BSN = $request->BSN;
        $customer->user_id = $userId;
        $customer->save();

        return $this->respond([
          'customer_id' => $customer->id
        ]);
      } else {
        $errors = $customer->errors();
        return $this->respondInvalid($errors);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customers = Customer::findOrFail($id);

        if(!count($customers)) {
          return $this->respondNotFound('Customers does not exist!');
        }

        $this->respond([
          'data' => $customers->customerTransformer->transform($customer)
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
