<?php
namespace App\Services;

use Carbon\Carbon;
use Iluminate\Support\Str;

class PlaceToPayPayment
{

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

private function createRequest(Payment $payment string $ipAdress, string $userAgent):array
{
    return[
        'auth' => $this->getAuth(),
        'buyer' => [
            'name' => auth()->user()->name,
            'lastname' => auth()->user()->lastname,
            'email' => auth()->user()->email,

        ],
        'payment' => [
            'reference' => '',
            'description' => 'prueba',
            'amount' => [
                'currency' => 'COP',
                'total' => \Cart::getTotal(),
            ]
            ],

        'expiration' =>Carbon::now()->addHour(),
        'returnUrl' => route('cart.shop'),
        'ipAddress' => $ipAdress,
        'userAgent' => $userAgent,

        ];
}

}
