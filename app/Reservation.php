<?php

namespace App;

use App\ValidationModel;

class Reservation extends ValidationModel
{
   /**
    * Rules for validation
    * @var array
    */
   protected $rules = [
      'activity' => 'required|min:3',
      'description' => 'required|min:5'
   ];

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
