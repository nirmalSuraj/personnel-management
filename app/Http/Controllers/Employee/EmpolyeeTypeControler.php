<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeType;
use App\Services\Config\Config;
use App\Services\Responses\Responses;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class EmpolyeeTypeControler extends Controller
{



    public  function index(Responses $responses)
    {

        return  $responses->data_found(["list" => EmployeeType::paginate(5)]);
    }


    public  function dropDown(Responses $responses)
    {
        return  $responses->data_found(["list" => EmployeeType::select("type", "id")->get()]);
    }

    public function find($id, Responses $responses)
    {
        $data =  EmployeeType::find($id);
        if ($data) {
            return  $responses->data_found(["list" => EmployeeType::findOrFail($id)]);
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

    public function Edit(Request $request, Responses $responses)
    {
        $request->validate([
            "id" => "required|integer",
            "type" => "required|string"
        ]);



        $affectedRow =  EmployeeType::where("id", $request->id)->update(["type" => $request->type]);
        if ($affectedRow) {
            return $responses->updated(["id" => $request->id]);
        } else {
            return $responses->bad_reauest();
        }
    }


    public function destroy($id, Responses $responses)
    {

        if (EmployeeType::where("id", "=", $id)->get()) {
            $deleted = EmployeeType::destroy($id);
            if ($deleted) {
                return $responses->deleted($id);
            } else {
                return $responses->delete_faild();
            }
        } else {
            return $responses->delete_faild("This type was deleted.");
        }
    }
}
