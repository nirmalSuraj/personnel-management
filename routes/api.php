<?php

use App\Http\Controllers\Auth\Auth;

use App\Http\Controllers\Employee\EmpolyeeTypeControler;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post("/register", [Auth::class, "store"]);
Route::post("/login", [Auth::class, "login"]);


Route::middleware('auth:sanctum')->group(function () {
    Route::post("/is-loged", [Auth::class, "isLoged"]);
    Route::post("/create-employee-type", [EmpolyeeTypeControler::class, "store"]);;
    Route::get("/get-employee-type", [EmpolyeeTypeControler::class, "index"]);
    Route::get("/get-employee-type/{id}", [EmpolyeeTypeControler::class, "find"]);
    Route::delete("/delete-employee-type/{id}", [EmpolyeeTypeControler::class, "destroy"]);
    Route::put("/update-employee-type", [EmpolyeeTypeControler::class, "edit"]);
    Route::get("/drop-douwn-types", [EmpolyeeTypeControler::class, "dropDown"]);


    /**  users crud */
    Route::get("/users", [UserController::class, "index"]);
    Route::get("/users/{id}", [UserController::class, "find"]);
    Route::post("/users", [UserController::class, "store"]);
    Route::put("/users", [UserController::class, "edit"]);
    Route::delete("/users/{id}", [UserController::class, "destroy"]);



    /**  create planning */
    Route::post("/schedule", [ScheduleController::class, "store"]);



    /**Payments */
    Route::get("/payment", [PaymentController::class, "index"]);
    Route::get("/payment/all", [PaymentController::class, "all"]);
});


/** this rout is for employee-waiter and employee-admin */

Route::middleware(['auth:sanctum', 'ability:employee-waiter,employee-admin'])->group(function () {
    Route::get("/schedule/{id?}/{date?}", [ScheduleController::class, "find"]);
    Route::get("/users/drop-down-users/all", [UserController::class, "DropDown"]);
});
