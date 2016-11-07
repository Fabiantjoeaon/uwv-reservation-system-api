<?php

namespace App\Http\Controllers;

class ApiController extends Controller {
  protected $statusCode = 200;

  public function getStatusCode() {
    return $this->statusCode;
  }

  public function setStatusCode($statusCode) {
    $this->statusCode = $statusCode;

    // Always return the current object from the method when chaining!
    return $this;
  }

  public function respondNotFound($message = 'Resource not found!') {
    return $this->setStatusCode(404)->respondWithError($message);
  }

  public function respond($data, $headers = []) {
    return response()->json($data, $this->getStatusCode(), $headers);
  }

  public function respondWithError($message) {
    return $this->respond([
        'error' => [
        'message' => $message,
        'status_code' => $this->getStatusCode()
      ]
    ]);
  }
}
