<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Retrieve user by customer
     */
    public function user() {
      return $this->belongsTo('App\User');
    }

    public function reservations() {
      return $this->hasMany('App\Reservation');
    }
}
