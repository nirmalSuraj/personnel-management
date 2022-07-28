<?php

namespace App\Services\Payment;

use App\Models\User;
use App\Models\WorkingHours;
use App\Traits\Calender\CalenderTraits;
use Carbon\Carbon;

class PaymentService
{

  use CalenderTraits;
  private int $user_id;
  private int $month;
  private int $year;

  public function CalPerMonth(string $month, int $year): PaymentService
  {

    $this->month = $this->GetMonthsNum($month);
    $this->year  = $year;
    return $this;
  }

  public  function GetPaymentByUser(int $user_id = null)
  {
    $this->user_id = $user_id;

    $data = $this->GetData()->where("user_id", "=", $user_id)->get()->toArray();
    foreach ($data as $index => $arr) {
      $calculatedHours =  $this->CalculateTime($arr["from"], $arr["till"]);
      $data[$index]["hours"]   = $calculatedHours["hours"];
      $data[$index]["minutes"] = $calculatedHours["minutes"];
      $data[$index]["earn"] =  $data[$index]["hours"] * $arr["salary_per_hour"];
    }

    return $data;
  }

  public  function GetPaymentByAll()
  {
    $data = $this->getData()->get()->toArray();

    $data =  $this->orderByUser($data);


    return $data;
  }
  private  function getData()
  {
    return  WorkingHours::with("user:id,name")->whereMonth("month", "=", $this->month)
      ->whereYear("month", "=", $this->year);
  }


  private function calculateTime(string $from, string $till): array
  {
    $from = Carbon::parse($from);
    $till = Carbon::parse($till);

    return [
      "hours"   => (float)number_format((float)($from->diffInMinutes($till) / 60), 2, '.', ''),
      "minutes" => $from->diffInMinutes($till)
    ];
  }

  private function orderByUser(array $data): array
  {
    $newRes = [];

    foreach ($data as $index => $arr) {

      $calculatedHours =  $this->CalculateTime($arr["from"], $arr["till"]);
      $arr["hours"]   = $calculatedHours["hours"];
      $arr["minutes"] = $calculatedHours["minutes"];
      $arr["earn"] =  ($arr["hours"] * $arr["salary_per_hour"]) ?? 0;
      $newRes[$arr["user"]["name"]][] = $arr;
    }

    return $newRes;
  }
}
