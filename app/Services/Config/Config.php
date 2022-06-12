<?php

namespace App\Services\Config;

require_once "ConfigArray.php";

class Config
{
  public function https(string $codeName)
  {
    return $GLOBALS["genralSettings"]["httpStatus"][$codeName];
  }
}
