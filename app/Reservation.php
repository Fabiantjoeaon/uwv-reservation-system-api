<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   /**
    *  Retrieve user for reservation
    */
    public function user() {
      return $this->belongsTo('App\User')->getResults();
    }

   /**
    *  Retrieve room for reservation
    */
    public function room() {
      return $this->belongsTo('App\Room')->getResults();
    }

    /**
     *  Retrieve customer for reservation
     */
    public function customer() {
      return $this->belongsTo('App\Customer')->getResults();
    }
}
