<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkingHours;
use App\Services\Responses\Responses;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class ScheduleController extends Controller
{
    //

    public function Validation(Request $request)
    {

        $request->validate([
            [
                "break" => "required|integer",
                "from" => "required|date|min:3",
                "till" => "nullable|date|min:3",
                "user_id" => "required|integer"
            ]

        ]);
    }



    public function Store(Request $request, Responses $responses)
    {
        $this->Validation($request);
        $exists = User::with("userDetails:user_id,salary_per_hour")->find($request->employee_type_id);
        if (!$exists) {
            return $responses->data_not_found("User Not found");
        }

        if (!$this->validateDate($request)) {

            return $responses->bad_reauest([], "Start and end dates are not correct");
        }
        $request->from =  new \DateTime($request->from);
        $request->till =  new \DateTime($request->till);

        $created =  WorkingHours::create([
            "break" => $request->break,
            "from" =>   $request->from->format("Y-m-d H:i:s"),
            "till" => $request->till->format("Y-m-d H:i:s"),
            "month" => $request->month,
            "user_id" => $request->employee_type_id,
            "salary_per_hour" => $exists->userDetails[0]->salary_per_hour ?? 0,
            "times_updated" => 0
        ]);


        if ($created->id > 0) {
            return $responses->ok(["id" => $created->id]);
        } else {
            return $responses->bad_reauest();;
        }
    }


    public function find(int $id = null, Responses $responses, string $date = null)
    {

        $data =  WorkingHours::select("id", "break", "from", "till", "month", "old_data", "times_updated");

        if (!is_null($date)) {

            $data = $data->whereMonth("month", $date);
        }
        $user = User::find(auth()->user()->id);

        //only admin
        if (!is_null($id) && in_array("employee-admin", $user->tokens[0]["abilities"])) {

            $data = $data->where("user_id", $id);
        } else {
            $user =   $user = User::with("userDetails:user_id,employee_type_id", 'userDetails.employeeType:id,type')->find(auth()->user()->id);
            if ($user->userDetails[0]->employeeType->type == "Waiter") {

                $data = $data->where("user_id", auth()->user()->id);
            }
        }

        $data = $data->paginate(10);

        if ($data) {
            return  $responses->data_found(["list" => $data]);
        } else {
            return $responses->data_not_found("Not found");
        }
    }

    private function validateDate(Request $request): bool
    {
        $from = Carbon::parse($request->from);
        $till = Carbon::parse($request->till);

        if ($till->gt($from)) {
            return true;
        } else {
            return false;
        }
    }
}
