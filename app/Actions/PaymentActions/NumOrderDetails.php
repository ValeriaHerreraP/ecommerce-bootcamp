<?php

namespace App\Actions\PaymentActions;

use App\Models\OrderDetail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class NumOrderDetails
{
    public static function execute(int $numorder): LengthAwarePaginator
    {
        return OrderDetail::where('order_id', 'LIKE', "$numorder")->latest()->paginate(10);
    }
}
