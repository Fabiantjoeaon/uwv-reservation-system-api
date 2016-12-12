<?php

namespace App;

use App\ValidationModel;

class Room extends ValidationModel
{
   /**
    *  Retrieve reservations for room
    */
    public function reservations() {
      return $this->hasMany('App\Reservation')->getResults();
    }
}
