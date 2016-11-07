<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
   /**
    *  Retrieve reservations for room
    */
    public function reservations() {
      return $this->hasMany('App\Reservation');
    }
}
