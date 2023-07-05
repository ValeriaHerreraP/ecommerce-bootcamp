<?php

namespace App\Services;

use App\Actions\PaymentActions\PaymentCreateAction;
use App\Models\OrderDetail;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Actions\PaymentActions\NumOrderDetails;
use App\Logger\CustomLogger;
use Illuminate\Validation\ValidationException;

class PlaceToPayPayment
{
    public function createSession(Request $request, string $order_id) : Payment
    {
        if ($order_id == '') {
            $order = PaymentCreateAction::execute($request->all());
            $orderExist = false;
        } else {
            $order = Payment::where('order_id', '=', "$order_id")->get()->first();
            $orderExist = true;
        }
        
        try{
           // throw ValidationException::withMessages(['your error message']);
            $result = Http::post(
                config('credentialesEvertec.url').'/api/session',
                $this->createRequest($order, $request->ip(), $request->userAgent())
            );
    
            if ($result->ok()) {
                if($orderExist == false){
                    $order->order_id = $result->json()['requestId'];
                }
                
                $order->url = $result->json()['processUrl'];
    
                $order->update();
    
                return $order;
            }
        }catch(\Exception $e){
            throw $e;
            CustomLogger::logErrorPasarelaPago($e);
        }
   
        //throw new \Exception($result->body());
    }

    public function getRequestInformation(Payment $order)
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
                dd($resultRequest);
                throw new \Exception($resultRequest->body());
            }

            $order_details = NumOrderDetails::execute($order->id);
            return view('payments.detailsOrder', ['payment' => $order_details, 'payment_status' => $order->status]);
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
                    'total' =>  $neworden->price_sum,
                ],
                ],

            'expiration' => Carbon::now()->addHour(),
            'returnUrl' => route('cart.resultPayments', ['id' => $neworden->id]),
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
