<?php

namespace App\Services\ConfigArray;



$ConfigArray = [
  "httpStatus" => [
    "bad request" => 400,
    "conflict" => 409,
    "ok" => 200,
    "created" => 201,
    "not found" => 404,
    "no content" => 204
  ]
];

$GLOBALS["genralSettings"] = $ConfigArray;
