<?php

namespace App;

// use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use HasApiTokens, Notifiable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     *  Retrieve customers for user
     */
    public function customers() {
      return $this->hasMany('App\Customer')->getResults();
    }

    /**
     *  Retrieve reservations for user
     */
    public function reservations() {
      return $this->hasMany('App\Reservation')->getResults();
    }
}
