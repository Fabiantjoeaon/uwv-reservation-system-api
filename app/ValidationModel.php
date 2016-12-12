<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ValidationModel extends Model {

  protected $rules = [];

  protected $errors;

  public function validate($data)
  {
      $validator = Validator::make($data, $this->rules);

      if ($validator->fails())
      {
          $this->errors = $validator->errors();
          return false;
      }

      return true;
  }

  public function errors()
  {
      return $this->errors;
  }
}
