<?php

namespace App\Actions\PaymentActions;

use App\Models\OrderDetail;

class NumOrderDetails
{
    public static function execute(string $numorder)
    {
        return  OrderDetail::where('order_id', 'LIKE', "$numorder")->latest()->paginate(10);
    }
}
