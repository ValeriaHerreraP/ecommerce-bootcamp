<?php

namespace App\Actions;

use App\Models\Payment;

class PaymentCreateAction
{
    public static function execute()
    {
        $price = \Cart::getTotal();

        return Payment::create([
        'user_id' => auth()->id(),
        'price_sum' => $price,
        ]);
    }
}