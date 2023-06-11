<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlaceToPayPayment;
use Illuminate\Contracts\View\View;
use App\Actions\NumOrderDetails;
use App\Actions\UserOrderAction;


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

    public function index(): View
    {
        $userpayment = UserOrderAction::execute();

        return view('payments.index', ['payment' => $userpayment]);
    }

    public function detailsCart(Request $request): View
    {
        $numorder= $request->state;
        $order = NumOrderDetails::execute($numorder);

        return view('payments.detailsOrder', ['payment' => $order]);
    }

}