<?php

namespace App;

use App\ValidationModel;

class Customer extends ValidationModel
{
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
