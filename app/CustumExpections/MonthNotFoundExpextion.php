<?php

namespace App\CustumExpections;

use Exception;

class MonthNotFoundExpextion extends Exception
{
  public function errorMessage()
  {

    //error message
    $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
      . ': <b>' . $this->getMessage();
    return $errorMsg;
  }
}
