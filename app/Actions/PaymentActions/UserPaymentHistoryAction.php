<?php

namespace App\Actions\PaymentActions;

use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;

class UserPaymentHistoryAction
{
    public static function execute(): LengthAwarePaginator
    {
        $user = auth()->user()->id;

        return  Payment::where('user_id', '=', "{$user}")->latest()->paginate(10);
    }
}
