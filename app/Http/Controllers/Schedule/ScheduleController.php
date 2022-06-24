<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkingHours;
use App\Services\Responses\Responses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //

    public function Validation(Request $request)
    {

        $request->validate([
            [
                "break" => "required|integer",
                "from" => "required|date",
                "till" => "nullable|date",
                "user_id" => "required|integer"
            ]

        ]);
    }



    public function Store(Request $request, Responses $responses)
    {
        $this->Validation($request);
        $exists = User::with("userDetails:user_id,salary_per_hour")->find($request->user_id);
        if (!$exists) {
            return $responses->data_not_found("User Not found");
        }

        if (!$this->validateDate($request)) {

            return $responses->bad_reauest([], "Start and end dates are not correct");
        }

        WorkingHours::create([
            "break" => $request->break,
            "from" => $request->from,
            "till" => $request->till,
            "month" => $request->month,
            "user_id" => $request->user_id,
            "salary_per_hour" => $exists->userDetails[0]->salary_per_hour,
            "times_updated" => 0
        ]);
    }


    public function find(int $id, Responses $responses)
    {
        $data =  WorkingHours::where("user_id", $id)->paginate(10);

        if ($data) {
            return  $responses->ok(["list" => $data]);
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
