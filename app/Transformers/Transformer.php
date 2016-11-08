<?php

namespace App\Transformers;

abstract class Transformer {
  /**
   * Transform a collection
   * 
   * @param  array  $items [items to be transformed]
   * @return array         [transformed item collection]
   */
  public function transformCollection(array $items) {
    return array_map([$this, 'transform'], $items);
  }

  /**
   * Transform a single item
   *
   * @param $item   item to be transformed
   * @return $item['i']   transformed item
   */
  public abstract function transform($item);
}
