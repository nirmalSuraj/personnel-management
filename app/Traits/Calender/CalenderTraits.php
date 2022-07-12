<?php

namespace App\Traits\Calender;

use App\CustumExpections\MonthNotFoundExpextion;

trait CalenderTraits
{
  private array $months = [
    "january"     => "01",
    "february"    => "02",
    "march"       => "03",
    "april"       => "04",
    "june"        => "05",
    "july"        => "07",
    "august"      => "08",
    "september"   => "09",
    "october"     => "10",
    "november"    => "11",
    "december"    => "12"

  ];


  public function GetMonthsNum(string $month)
  {
    if (!array_key_exists($month, $this->months)) {
      throw new MonthNotFoundExpextion("Month is not valid", 200);
    }

    return (int)$this->months[$month];
  }
}
