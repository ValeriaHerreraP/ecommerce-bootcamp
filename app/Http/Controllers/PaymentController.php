<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Services\PlaceToPayPayment;
use Illuminate\Contracts\View\View;

class PaymentController extends Controller
{
    public function pagos(Request $request):View
    {
        $payments = new PlaceToPayPayment();
        $payments->createSession($request);

        return $payments->getRequestInformation();
    }
      
    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        return $placeToPayPayment->getRequestInformation();
    }

    public function index()
    {
        $user = auth()->user()->id;

        
        $userpayment = Payment::where('user_id', '=', "{$user}")->paginate(10);


        return view('payments.index', ['payment' => $userpayment]);
    }

}