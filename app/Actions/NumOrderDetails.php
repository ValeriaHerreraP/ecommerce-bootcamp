<?php

namespace App\Actions;

use App\Models\OrderDetails;

class NumOrderDetails
{
    public static function execute($numorder)
    {

        return  OrderDetails::where('order_id', 'LIKE', "$numorder")->latest()->paginate(10);
    }
}