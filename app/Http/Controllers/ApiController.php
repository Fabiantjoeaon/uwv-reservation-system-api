<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller {
  /**
   * @var integer Standard server status code
   */
  protected $statusCode = 200;

  /**
   * Get status code
   * @return $statuscode
   */
  public function getStatusCode() {
    return $this->statusCode;
  }

  /**
   * Set status code
   * @return $statuscode
   */
  public function setStatusCode($statusCode) {
    $this->statusCode = $statusCode;
    // Always return the current object from the method when chaining!
    return $this;
  }

  /**
   * General response method for data or errors with status code
   * @param  array $data      Response data
   * @param  array $headers   Headers for response
   * @return Response
   */
  public function respond($data, $headers = []) {
    return response()->json($data, $this->getStatusCode(), $headers);
  }

  /**
   * Respond with an error
   * @param  string $message Message to be returned
   * @return Response
   */
  public function respondWithError($message) {
    return $this->respond([
        'error' => [
        'message' => $message,
        'status_code' => $this->getStatusCode()
      ]
    ]);
  }

  /**
   * Response for not found resource
   * @param  string $message Message to be passed on to call
   * @return Error
   */
  public function respondNotFound($message = 'Resource not found!') {
    return $this->setStatusCode(404)->respondWithError($message);
  }

  public function respondUnauthorized($message = 'Invalid credentials!') {
    return $this->setStatusCode(401)->respondWithError($message);
  }

  /**
   * Response for internal server error
   * @param  string $message Message to be passed on to call
   * @return Error
   */
  public function respondInternalError($message = 'Internal error!') {
    return $this->setStatusCode(500)->respondWithError($message);
  }
}
