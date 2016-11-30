<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Redis;
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
     * Check if reservation is currently active
     * @param  [Date] $start_date Beginning of reservation
     * @param  [Date] $end_date   Ending of reservation
     * @param  [Date] $now        Date now
     * @return [boolean]
     */
    private function checkIfDateIsInRange($start_date, $end_date, $now) {
      $start_ts = strtotime($start_date);
      $end_ts = strtotime($end_date);
      $now_ts = strtotime($now);

      return (($now_ts >= $start_ts) && ($now_ts <= $end_ts));
    }

    /**
     * Check if the date of the reservation has passed
     * @param  [Date] $end_date End date of reservation
     * @param  [Date] $now      Date now
     * @return [boolean]
     */
    private function checkIfDateHasPassed($end_date, $now) {
      $end_ts = strtotime($end_date);
      $now_ts = strtotime($now);

      return ($now_ts > $end_ts);
    }

    /**
     * Send event to client so that it can re-render
     * @param  [Room]   $room Room that has been updated
     * @return [void]
     */
    private function sendClientRenderEvent(Room $room) {
        $data = [
          'event' => 'roomHasUpdated',
          'data' => [
            'id' => $room->id
          ]
        ];

        Redis::publish('room-channel', json_encode($data));
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
      error_log(" ");
      error_log("This update was at {$now}");

      foreach($reservations as $reservation) {
        $room = Reservation::find($reservation->id)->room();
        $reservationActivity = $reservation->activity;
        $roomLocation = $room->location;

        // Check if reservation is now
        if($this->checkIfDateIsInRange($reservation->start_date_time, $reservation->end_date_time, $now)) {
          error_log("${reservationActivity} is now at ${roomLocation}");
          if($room->is_reserved_now) {
            continue;
          } else {
            $room->is_reserved_now = true;
            $reservation->is_active_now = true;
            $reservation->save();
            $room->save();

            $this->sendClientRenderEvent($room);
          }
        }

        // Reservation has already passed...
        elseif ($this->checkIfDateHasPassed($reservation->end_date_time, $now)) {
          if($reservation->has_passed) {
            continue;
          } else {
            error_log("${reservationActivity} has passed");
            $room->is_reserved_now = false;
            $room->save();
            $this->sendClientRenderEvent($room);

            // Delete old reservations with other cron job
            // TODO: Maybe desktop notification on passed activity??
            $reservation->has_passed = true;
            $reservation->is_active_now = false;
            $reservation->save();
          }

        }
      }
    }
}
