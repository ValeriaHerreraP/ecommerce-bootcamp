<?php

namespace App\Actions\PaymentActions;

use App\Models\Payment;

use Darryldecode\Cart\Facades\CartFacade as Cart;

class PaymentCreateAction
{
    public static function execute(): Payment
    {
        $price = Cart::getTotal();

        return Payment::create([
        'user_id' => auth()->id(),
        'price_sum' => $price,
        ]);
    }
}
