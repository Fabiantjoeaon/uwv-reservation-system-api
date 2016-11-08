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
      'date_time' => $reservation['date_time'],
      'length_minutes' => $reservation['length_minutes'],
      'activity' => $reservation['activity'],
      'status' => $reservation['status'],
      'number_persons' => $reservation['number_persons']
    ];
  }
}
