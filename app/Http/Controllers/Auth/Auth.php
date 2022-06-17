<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Responses\Responses;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\Expectation;

class Auth extends Controller
{

    public function store(Request $request, Responses $responses)
    {

        $users =  $request->validate(
            [
                "name" => "required",
                "email" => "required|unique:users,email",
                "password" => "required|confirmed|min:8"
            ]
        );

        $user =  User::create([
            "name" =>   $users["name"],
            "email" => $users["email"],
            "password" => bcrypt($users["password"])
        ]);

        $token = $user->createToken("token")->plainTextToken;

        return $responses->public_create(["token" => $token]);
    }


    public function login(Request $request, Responses $responses)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return $responses->bad_reauest([
                "errors" => ["Email or password incorrect"]
            ]);
        }

        $token = $user->createToken("token")->plainTextToken;

        return $responses->ok(["token" => $token], "loged in");
    }


    public function isLoged(Request $request, Responses $responses)
    {
        $validate = $request->validate(["token" => "required"]);


        return $responses->ok(["token" => $request->token], "loged in");
    }
}
