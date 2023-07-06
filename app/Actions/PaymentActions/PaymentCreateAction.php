<?php

namespace App\Actions\PaymentActions;

use App\Models\Payment;

class PaymentCreateAction
{
    public static function execute(): Payment
    {
        $price = \Cart::getTotal();

        return Payment::create([
        'user_id' => auth()->id(),
        'price_sum' => $price,
        ]);
    }
}
