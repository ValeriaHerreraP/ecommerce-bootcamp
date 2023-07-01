<?php

namespace App\Services;

use App\Actions\PaymentActions\PaymentCreateAction;
use App\Models\OrderDetail;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceToPayPayment
{
    public function createSession(Request $request, $neworden)
    {
        if ($neworden == '') {
            $neworden = PaymentCreateAction::execute($request->all());
        }

        $result = Http::post(
            config('credentialesEvertec.url').'/api/session',
            $this->createRequest($neworden, $request->ip(), $request->userAgent())
        );

        if ($result->ok()) {
            $neworden->order_id = $result->json()['requestId'];
            $neworden->url = $result->json()['processUrl'];

            $neworden->update();

            redirect()->to($neworden->url)->send();
        }

        // redirect()->to($neworden->url)->send();
        return view('product.index');

        //throw new \Exception($result->body());
    }

    public function getRequestInformation()
    {
        $neworder = Payment::query()->where('user_id', '=', auth()->id())
        ->where('status', '=', 'PENDING')->latest()->first();

        $resultRequest = Http::post(
            config('credentialesEvertec.url')."/api/session/$neworder->order_id",
            [
               'auth' => $this->getAuth(),
            ]
        );

        if ($resultRequest->ok()) {
            $status = $resultRequest->json()['status']['status'];

            if ($status == 'APPROVED' || $status == 'APPROVED_PARTIAL') {
                $neworder->completed();
            } elseif ($status == 'REJECTED' || $status == 'PARTIAL_EXPIRED' || $status == 'FAILED') {
                $neworder->canceled();
            } else {
                throw new \Exception($resultRequest->body());
            }

            $cartCollection = \Cart::getContent();

            foreach ($cartCollection as $items) {
                $subtotal = ($items->price * $items->quantity);

                OrderDetail::create([
                    'user_id' => auth()->id(),
                    'order_id'=> $neworder->id,
                    'name'=> $items->name,
                    'price'=> $items->price,
                    'quantity'=>$items->quantity,
                    'subtotal' =>$subtotal,
                    'total'=> \Cart::getTotal(),
                    ]);
            }

            return view('cart.payments', ['cartCollection' => $cartCollection, 'neworder' =>$neworder]);
        }
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
            'nonce'=> base64_encode($nonce),
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
                'description' => $this->recorrer(),
                'amount' => [
                    'currency' => 'COP',
                    'total' => \Cart::getTotal(),
                ],
                ],

            'expiration' => Carbon::now()->addHour(),
            'returnUrl' => route('cart.resultPayments'),
            'ipAddress' => $ipAdress,
            'userAgent' => $userAgent,

            ];
    }

    public function recorrer():string
    {
        $datos = \Cart::getContent();

        $info = '';

        foreach ($datos as $items) {
            $items->name;
            $items->quantity;
            $info = $info.' - '.$items->name.'. Cantidad:  '.$items->quantity.'.  ';
        }

        return $info;
    }
}
