<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use App\Room;

class UpdateRoomForReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dorsia:updaterooms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates room status for each reservation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * [checkIfDateIsInRange description]
     * @param  [type] $start_date [description]
     * @param  [type] $end_date   [description]
     * @param  [type] $now        [description]
     * @return [type]             [description]
     */
    private function checkIfDateIsInRange($start_date, $end_date, $now) {
      $start_ts = strtotime($start_date);
      $end_ts = strtotime($end_date);
      $now_ts = strtotime($now);

      return (($now_ts >= $start_ts) && ($now_ts <= $end_ts));
    }

    /**
     * [checkIfDateHasPassed description]
     * @param  [type] $end_date [description]
     * @param  [type] $now      [description]
     * @return [type]           [description]
     */
    private function checkIfDateHasPassed($end_date, $now) {
      $end_ts = strtotime($end_date);
      $now_ts = strtotime($now);

      return ($now_ts > $end_ts);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $reservations = Reservation::all();
      $now = date("Y-m-d H:i:s");

      foreach($reservations as $reservation) {
        $room = Reservation::find($reservation->id)->room();
        $res = $reservation->activity;
        $rom = $room->location;

        // Check if reservation is now
        if($this->checkIfDateIsInRange($reservation->start_date_time, $reservation->end_date_time, $now)) {
          error_log("${res} is now at ${rom}");
          if($room->is_reserved_now) {
            continue;
          } else {
            $room->is_reserved_now = true;
            $room->save();

            //TODO: Re-render client
          }
        }

        // Reservation has already passed...
        elseif ($this->checkIfDateHasPassed($reservation->end_date_time, $now)) {
          error_log("${res} has passed");
          $room->is_reserved_now = false;
          $room->save();
          // Flag reservation to passed, delete with other cron job
          $reservation->delete();
        }

        // Reservation is in the future
        else {
          //TODO: Set DB record if reservation is this day
          error_log("${res} has yet to come");
        }
      }
    }
}
