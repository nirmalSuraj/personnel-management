<?php

namespace App\Services\Responses;

use Facade\FlareClient\Http\Response;

class Responses
{


  private array $defaultResponse = [
    "message" => "",
    "sccess" => false,
    "auth" => false
  ];




  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */

  public function bad_reauest(array $data, string $message = "Bad request")
  {

    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, 400);
  }


  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function ok(array $data, string $message = "Done")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, 200);
  }

  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function conflict(array $data, string $message = "Conflict")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, 400);
  }

  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function created(array $data, string $message = "Created")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;

    $data = array_merge($data, $this->defaultResponse);
    return Response($data, 201);
  }

  /**
   * create without login
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function public_create(array $data, string $message = "Created")
  {
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;

    $data = array_merge($data, $this->defaultResponse);
    return Response($data, 201);
  }
}
