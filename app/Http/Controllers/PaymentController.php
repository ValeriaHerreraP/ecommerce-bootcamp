<?php

namespace App\Http\Controllers;

use App\Actions\PaymentActions\NumOrderDetails;
use App\Actions\PaymentActions\UserPaymentHistoryAction;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Services\PlaceToPayPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Actions\CartActions\ClearCartAction;

class PaymentController extends Controller
{
    public function pay(Request $request): RedirectResponse
    {
        $payments = new PlaceToPayPayment();

        try {
            $order = $payments->createSession($request, "");
        }catch(\Exception $e){
            return redirect()->route('dashboard');
            //CAMBIAR
        }

            $cartCollection = \Cart::getContent();

            foreach ($cartCollection as $items) {
                $subtotal = ($items->price * $items->quantity);

                //ACTION 
                OrderDetail::create([
                    'user_id' => auth()->id(),
                    'order_id'=> $order->id,
                    'name'=> $items->name,
                    'price'=> $items->price,
                    'quantity'=>$items->quantity,
                    'subtotal' =>$subtotal,
                    'total'=> \Cart::getTotal(),
                    ]);
            }

            \Cart::clear();

            return redirect()->to($order->url)->send();
    }

    public function retryPay(Request $request):RedirectResponse
    {
        $orden_id = $request->order_id;
        $payments = new PlaceToPayPayment();

        $order = $payments->createSession($request, $orden_id);
        return redirect()->to($order->url)->send();
    }

    public function processResponse(Request $request)
    {
        $id = $request->query('id');
        $order = Payment::query()->where('user_id', '=', auth()->id())
        ->where('id', '=', $id)->latest()->first();

        $placeToPayPayment = new PlaceToPayPayment();
        return $placeToPayPayment->getRequestInformation($order);
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

        return view('payments.detailsOrder', ['payment' => $order, 'payment_status' => ""]);
    }
}
