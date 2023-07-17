<?php

namespace App\Services;

use App\Actions\PaymentActions\NumOrderDetails;
use App\Actions\PaymentActions\OrderDetailsAction;
use App\Actions\PaymentActions\PaymentCreateAction;
use App\Loggers\Logger;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\throwException;

class PlaceToPayPayment
{
    public function createSession(Request $request, string $order_id) : Payment
    {
        if ($order_id == '') {
            $order = PaymentCreateAction::execute();
            $orderExist = false;
        } else {
            $order = Payment::query()->where('order_id', '=', "$order_id")->first();
            $orderExist = true;
        }

        OrderDetailsAction::execute($order);

        try {
            $result = Http::post(
                config('credentialesEvertec.url').'/api/session',
                $this->createRequest($order, $request->ip(), $request->userAgent())
            );

            if ($result->ok()) {
                if ($orderExist == false) {
                    $order->order_id = $result->json()['requestId'];
                }

                $order->url = $result->json()['processUrl'];

                $order->update();

                Logger::payment_session_created_successfully();

                return $order;
            }

            throw new \Exception($result->body());
        } catch(\Exception $error) {
            Logger::payment_gateway_error($error);
            throw $error;
        }
    }

    public function getRequestInformation(Payment $order): View
    {
        $placetopay_id = explode('/', $order->url)[5];
        $resultRequest = Http::post(
            config('credentialesEvertec.url')."/api/session/$placetopay_id",
            [
               'auth' => $this->getAuth(),
            ]
        );

        if ($resultRequest->ok()) {
            $status = $resultRequest->json()['status']['status'];

            if ($status == 'APPROVED' || $status == 'APPROVED_PARTIAL') {
                $order->completed();
            } elseif ($status == 'REJECTED' || $status == 'PARTIAL_EXPIRED' || $status == 'FAILED') {
                $order->canceled();
            } else {
                throw new \Exception($resultRequest->body());
            }

            Logger::order_payment_status($status, $order->id);

            $order_details = NumOrderDetails::execute($order->id);

            return view('payments.detailsOrder', ['payment' => $order_details, 'payment_status' => $order->status]);
        }

        return view('cart.index');
    }

    private function getAuth(): array
    {
        $nonce = rand();
        $seed = date(format:'c');

        return [
            'login'=> config('credentialesEvertec.login'),
            'tranKey'=> base64_encode(
                hash(
                    'sha256',
                    $nonce.$seed.config('credentialesEvertec.tranKey'),
                    true,
                )
            ),
            'nonce'=> base64_encode(strval($nonce)),
            'seed' => $seed,
        ];
    }

    public function createRequest(Payment $neworden, string $ipAdress, string $userAgent):array
    {
        return[
            'auth' => $this->getAuth(),
            'buyer' => [
                'name' => auth()->user()->name,
                'surname' => auth()->user()->lastname,
                'email' => auth()->user()->email,
                'mobile' => auth()->user()->phone,

            ],
            'payment' => [
                'reference' => $neworden->id,
                'description' => $this->order_details_in_the_payment_gateway($neworden),
                'amount' => [
                    'currency' => 'COP',
                    'total' =>  $neworden->price_sum,
                ],
                ],

            'expiration' => Carbon::now()->addHour(),
            'returnUrl' => route('cart.resultPayments', ['id' => $neworden->id]),
            'ipAddress' => $ipAdress,
            'userAgent' => $userAgent,

            ];
    }

    public function order_details_in_the_payment_gateway($order):string
    {
        $datos = NumOrderDetails::execute($order->id);

        $info = '';

        foreach ($datos as $items) {
            $info = $info.' - '.$items->name.'. Cantidad:  '.$items->quantity.'.  ';
        }

        return $info;
    }
}
