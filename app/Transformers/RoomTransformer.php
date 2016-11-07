<?php

namespace App\Transformers;

class RoomTransformer extends Transformer {
  public function transform($room) {
    return [
      'name' => $room['location'].'.'.$room['floor'].'.'.$room['number'],
      'floor' => $room['floor'],
      'number' => $room['number'],
      'capacity' => $room['capacity'],
      'color' => $room['color'],
      'type' => $room['type'],
      'has_pc' => (boolean) $room['has_pc']
    ];
  }
}
