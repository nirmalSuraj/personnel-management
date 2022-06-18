<?php

namespace App\Services\Users;

use App\Models\EmployeeType;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Client\Request;
use Illuminate\Validation\Rules\In;

class UsersService
{


  public function Create(array $fullRequest): array
  {
    $listOfUpdatedIds = [];
    $holdInsertIdByIndex = [];
    foreach ($fullRequest as $table => $arraysToInsert) {
      foreach ($arraysToInsert as $index => $arrayToInsert) {
        if ($table == "users") {

          $holdInsertIdByIndex[$index] = $this->CreateUser($arrayToInsert);
          $listOfUpdatedIds[] =  $holdInsertIdByIndex[$index];
        } else    if ($table == "details") {

          $arrayToInsert["user_id"] = $holdInsertIdByIndex[$index];

          $listOfUpdatedIds[] = $this->CreateUserDetails($arrayToInsert);
        }
      }
    }

    return $listOfUpdatedIds;
  }


  private function CreateUser(array $insertUser): int
  {

    $user = User::create($insertUser);
    return   $user->id;
  }

  private function CreateUserDetails(array $details): int
  {
    $created = UserDetails::create($details);
    return     $created->id;
  }

  public function update(array $fullRequest)
  {
    $listOfUpdatedIds = [];
    $holdUpdatedIdByIndex = [];
    foreach ($fullRequest as $table => $arraysToInsert) {
      foreach ($arraysToInsert as $index => $arrayToInsert) {
        if ($table == "users") {

          $this->UpdateUser($arrayToInsert);
          $holdUpdatedIdByIndex[$index] =  $arrayToInsert["id"];
          $listOfUpdatedIds[] =  $holdUpdatedIdByIndex[$index];
        } else    if ($table == "details") {

          $listOfUpdatedIds[] = $this->UpdateUserDetails($arrayToInsert, $holdUpdatedIdByIndex[$index]);
        }
      }
    }

    return $listOfUpdatedIds;
  }


  private function UpdateUser(array $insertUser): int
  {
    $id = $insertUser["id"];
    unset($insertUser["id"]);

    $user = User::where("id",  $id)->update($insertUser);

    return      $user;
  }

  private function UpdateUserDetails(array $details, int $user_id): int
  {

    return  UserDetails::where("user_id", $user_id)->update($details);
  }


  public function checkIfEmployeeType(int $employeeType): bool
  {

    $exits =  EmployeeType::find($employeeType);

    if (!$exits) {

      return false;
    } else {
      return true;
    }
  }
}
