<?php

namespace App\Services\Responses;

use App\Services\Config\Config;
use Facade\FlareClient\Http\Response;

class Responses extends Config
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

  public function bad_reauest(array $data =  [], string $message = "Bad request")
  {

    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, $this->https("bad request"));
  }


  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function ok(array $data =  [], string $message = "Done")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data,  $this->https("ok"));
  }

  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function conflict(array $data = [], string $message = "Conflict")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, $this->https("conflict"));
  }

  /**
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function created(array $data = [], string $message = "Created")
  {
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;

    $data = array_merge($data, $this->defaultResponse);
    return Response($data, $this->https("created"));
  }

  /**
   * create without login
   * @param array $data array of to send
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function public_create(array $data = [], string $message = "Created")
  {
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $this->defaultResponse["auth"] = false;
    $data = array_merge($data, $this->defaultResponse);
    return Response($data, $this->https("created"));
  }


  public function data_found(array $data = [], string $message = "")
  {
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $this->defaultResponse["auth"] = true;

    $data = array_merge($data, $this->defaultResponse);
    return Response($data, $this->https("ok"));
  }

  public function data_not_found(string $message = "")
  {
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["list"] = [];

    $data = $this->defaultResponse;
    return Response($data, $this->https("ok"));
  }
  /**
   * @param int $id id of deleted element
   *  @param string $message by default is deleted
   */
  public function deleted(int $id = 0, string $message = "deleted")
  {
    $this->defaultResponse["sccess"] = true;
    $this->defaultResponse["message"] = $message;
    $this->defaultResponse["auth"] = true;
    $this->defaultResponse["id"] = $id;
    $this->defaultResponse["status"] = $id;
    $data = $this->defaultResponse;

    return Response($data,  200);
  }

  /**
   * @param int $id id of deleted element
   *  @param string $message by default is Recorde is already deleted or does not exist 
   */
  public function delete_faild(string $message = "Recorde is already deleted or does not exist .")
  {
    $this->defaultResponse["sccess"] = false;
    $this->defaultResponse["message"] = $message;
    $this->defaultResponse["auth"] = true;

    $data = $this->defaultResponse;

    return Response($data,  $this->https("conflict"));
  }

  public function Unauthorized()
  {
    $this->defaultResponse["sccess"] = false;
    $this->defaultResponse["message"] = "Unauthorized";
    $this->defaultResponse["auth"] = false;
    $data = $this->defaultResponse;

    return Response($data,  $this->https("unauthorized"));
  }
}
