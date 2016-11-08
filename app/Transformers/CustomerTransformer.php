<?php

namespace App\Transformers;

class CustomerTransformer extends Transformer {
  /**
   * Transformer for rooms
   * @param $room Room to be transformed
   * @return array  Transformed rooms
   */
  public function transform($customer) {
    return [
      'BSN' => $customer['BSN'],
      'first_name' => $customer['first_name'],
      'last_name' => $customer['last_name']
    ];
  }
}
