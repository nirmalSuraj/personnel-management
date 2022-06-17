<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUSers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {


        $request->validate(
            [
                "users" => "required|array",
                "users.*.name" => "required|string",
                "users.*.email" => "required|string",
                "users.*.password" => "required|string",
                "details" => "required|array",
                "details.*.national_insurance" => "required|string",
                "details.*.kids" => "integer",
                "details.*.week_hours" => "required|integer",
                "details.*.relationship" => "integer",
                "details.*.salary_per_hour" => "integer",
                "details.*.employee_type_id" => "required|integer",
            ]
        );
    }
}
