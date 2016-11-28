<?php

namespace App\Transformers;

class ReservationTransformer extends Transformer {
  /**
   * Transformer for rooms
   * @param $room Room to be transformed
   * @return array  Transformed rooms
   */
  public function transform($reservation) {
    return [
      'start_date_time' => $reservation['start_date_time'],
      'length_minutes' => $reservation['length_minutes'],
      'end_date_time' => $reservation['end_date_time'],
      'activity' => $reservation['activity'],
      'is_active_now' => $reservation['is_active_now'],
      'number_persons' => $reservation['number_persons']
    ];
  }
}
