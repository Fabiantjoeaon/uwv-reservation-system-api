<?php

namespace App;

use App\ValidationModel;

class Customer extends ValidationModel
{
    /**
     * Rules for validation
     * @var array
     */
    protected $rules = [
       'first_name' => 'required|min:2',
       'last_name' => 'required|min:2',
       'email' => 'required|min:2',
       'BSN' => 'required|min:6'
    ];

    /**
     * Retrieve user by customer
     */
    public function user() {
      return $this->belongsTo('App\User')->getResults();
    }

    /**
     *  Retrieve reservations for customer
     */
    public function reservations() {
      return $this->hasMany('App\Reservation')->getResults();
    }
}
