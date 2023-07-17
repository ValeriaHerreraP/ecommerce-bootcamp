<?php

namespace App\Actions\PaymentActions;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NumOrderDetails
{
    public static function execute(int $numorder): LengthAwarePaginator
    {
        return OrderDetail::where('order_id', 'LIKE', "$numorder")->latest()->paginate(10);
    }
}
