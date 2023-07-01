<?php

namespace App\Http\Controllers;

use App\Actions\PaymentActions\NumOrderDetails;
use App\Actions\PaymentActions\UserPaymentHistoryAction;
use App\Models\Payment;
use App\Services\PlaceToPayPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request):View
    {
        $neworder = '';
        $payments = new PlaceToPayPayment();
        $payments->createSession($request, $neworder);

        return $payments->getRequestInformation();
    }

    public function retryPay(Request $request):View
    {
        $orden_id = $request->order_id;

        $ordenretry = Payment::where('order_id', '=', "$orden_id")->get();

        $payments = new PlaceToPayPayment();

        $payments->createSession($request, $ordenretry);

        return $payments->getRequestInformation();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        return $placeToPayPayment->getRequestInformation();
    }

    public function userPaymentHistory(): View
    {
        $userpayment = UserPaymentHistoryAction::execute();

        return view('payments.index', ['payment' => $userpayment]);
    }

    public function userOrderDetails(Request $request): View
    {
        $numorder = $request->state;
        $order = NumOrderDetails::execute($numorder);

        return view('payments.detailsOrder', ['payment' => $order]);
    }
}
