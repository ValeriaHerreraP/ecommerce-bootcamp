<?php
namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PlaceToPayPayment
{
    public function createSession(Request $request)
    {
       $price = \Cart::getTotal();

        $neworden=  Payment::create([
        'user_id' => auth()->id(),
        'price_sum' => $price,
        ]);

        $result = Http::post(config('credentialesEvertec.url').'/api/session',
        $this->createRequest($neworden, $request->ip(), $request->userAgent()));

        if($result -> ok()) {
        $neworden->order_id = $result->json()['requestId'];
        $neworden->url = $result->json()['processUrl'];  

        $neworden->update();

        redirect()->to($neworden->url)->send();

        
        }

        //redirigir al usuario a un lugar para indicarle porque no funciono

         throw new \Exception($result->body());

    }

    public function getRequestInformation()
    {
        $neworder = Payment::query()->where('user_id', '=', auth()->id())
        ->where('status', '=', 'PENDING')->latest()->first();

        $resultRequest = Http::post(config('credentialesEvertec.url')."/api/session/$neworder->order_id",
         [
            'auth' => $this->getAuth(),
         ]
         );

         if($resultRequest->ok())
         {
            $status = $resultRequest->json()['status']['status'];
            $msj = $resultRequest->json()['status']['message'];

            if($status == 'APPROVED'  || $status ==  'APPROVED_PARTIAL') {
                $neworder->completed();
            }
            else if($status == 'REJECTED' || $status == 'PARTIAL_EXPIRED' || $status == 'FAILED')
            {
                $neworder->canceled();
            }
            else 
            {
                throw new \Exception($resultRequest->body());
            }

            $cartCollection = \Cart::getContent();
            return view('cart.payments',['cartCollection' => $cartCollection, 'neworder' =>$neworder]);

         }
    }

    private function getAuth(): array
    {
        $nonce = rand();
        $seed = date(format:'c');
        return [
            'login'=> config('credentialesEvertec.login') ,
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
                ]
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

       foreach($datos as $items) {
        $items->name;
        $items->quantity;
        $info = $info.' - '.$items->name.'. Cantidad:  '.$items->quantity.'.  ';
        }
      return $info;
    }

}
