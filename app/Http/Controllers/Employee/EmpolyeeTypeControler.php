<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeType;
use App\Services\Responses\Responses;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class EmpolyeeTypeControler extends Controller
{



    public  function index(Responses $responses)
    {

        return  $responses->send_data(["list" => EmployeeType::all()]);
    }

    public function find($id, Responses $responses)
    {
        $data =  EmployeeType::find($id);
        if ($data) {
            return  $responses->send_data(["list" => EmployeeType::findOrFail($id)]);
        } else {
            return  $responses->data_not_found();
        }
    }



    public function store(Request $request, Responses $responses)
    {
        $request->validate([
            "type" => "required"
        ]);

        $EmployeeType =   EmployeeType::create($request->all());

        if ($EmployeeType) {

            return $responses->created(["id" => $EmployeeType->id]);
        } else {
            return $responses->bad_reauest();
        }
    }
}
