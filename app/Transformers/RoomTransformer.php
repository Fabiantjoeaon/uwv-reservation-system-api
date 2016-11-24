<?php

namespace App\Transformers;

class RoomTransformer extends Transformer {
  /**
   * Transformer for rooms
   * @param $room Room to be transformed
   * @return array  Transformed rooms
   */
  public function transform($room) {
    return [
      'id' => $room['id'],
      'name' => $room['location'].'.'.$room['floor'].'.'.$room['number'],
      'floor' => $room['floor'],
      'number' => $room['number'],
      'capacity' => $room['capacity'],
      'color' => $room['color'],
      'type' => $room['type'],
      'invalid' => (boolean) $room['invalid'],
      'has_pc' => (boolean) $room['has_pc'],
      'is_reserved' => (boolean) $room['is_reserved'],
    ];
  }
}
