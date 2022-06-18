<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUSers;
use App\Models\EmployeeType;
use App\Models\User;
use App\Services\Responses\Responses;
use App\Services\Users\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{


    public function index(Responses $responses)
    {
        $data = User::with("userDetails")->paginate(10);

        return $responses->data_found(["list" => $data]);
    }

    public function find($id, Responses $responses)
    {

        $data =   $data = User::with("userDetails")->where("id", $id)->get();

        if ($data) {
            return  $responses->data_found(["list" =>   $data]);
        } else {
            return  $responses->data_not_found();
        }
    }



    public function validates(Request $request)
    {

        $ruls =   [
            "users" => "required|array",
            "users.*.name" => "required|string",
            "users.*.email" => "required|string|email|unique:users,email",
            "details" => "required|array",
            "details.*.national_insurance" => "required|string",
            "details.*.kids" => "integer",
            "details.*.week_hours" => "required|integer",
            "details.*.relationship" => "integer",
            "details.*.salary_per_hour" => "integer",
            "details.*.employee_type_id" => "required|integer",
        ];

        $action =  explode("@", Route::currentRouteAction())[1];
        if ($action == "store") {
            $ruls["users.*.password"] = "required|string";
        }
        if ($action == "edit") {
            $ruls["users.*.id"] = "required|integer";
        }

        $request->validate($ruls);
    }

    public function store(Request $request, UsersService $users, Responses $responses)
    {
        $this->validates($request);
        foreach ($request->all()["details"] as $arr) {
            if (!$users->checkIfEmployeeType($arr["employee_type_id"])) {
                return $responses->conflict(["id" => $arr["employee_type_id"]], "Employee type does not exits");
            };
        }
        $inserted =  $users->Create($request->all());

        if (count($inserted)) {
            return $responses->created(["id" => $inserted]);
        } else {
            return $responses->create_faild();
        }
    }


    public function edit(Request $request, UsersService $users, Responses $responses)
    {

        $this->validates($request);

        foreach ($request->all()["details"] as $arr) {
            if (!$users->checkIfEmployeeType($arr["employee_type_id"])) {
                return $responses->conflict(["id" => $arr["employee_type_id"]], "Employee type does not exits");
            };
        }

        if ($users->update($request->all())) {
            return $responses->updated(["id" => 1]);
        } else {
            return $responses->bad_reauest();
        }
    }


    public function destroy(int $id, Responses $responses)
    {

        $deleted =  User::destroy($id);
        if ($deleted) {
            return $responses->deleted($id);
        } else {
            return $responses->delete_faild();
        }
    }
}
