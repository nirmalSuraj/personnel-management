<?php

namespace App\Http\Controllers\Payment;


use App\CustumExpections\MonthNotFoundExpextion;
use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use App\Services\Responses\Responses;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function validates(Request $request)
    {


        $request->validate([
            "user_id" => "integer",
            "year"    => "required|integer",
            "month"   => "required|string"
        ]);
    }



    public function index(Request $request, Responses $responses, PaymentService $getPayments)
    {

        $this->validates($request);
        try {
            $data = $getPayments->CalPerMonth($request->month, $request->year)
                ->GetPaymentByUser($request->user_id);
        } catch (MonthNotFoundExpextion $e) {
            return $responses->conflict();
        }

        return $responses->data_found(["list" => $data]);
    }

    public function all(Request $request, Responses $responses, PaymentService $getPayments)
    {

        try {
            $data = $getPayments->CalPerMonth($request->month, $request->year)->GetPaymentByAll();
        } catch (MonthNotFoundExpextion $e) {
            return $responses->conflict();
        }

        return $responses->data_found(["list" => $data ?? []]);
    }
}
