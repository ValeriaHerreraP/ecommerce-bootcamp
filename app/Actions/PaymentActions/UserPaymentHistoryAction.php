<?php

namespace App\Actions\PaymentActions;

use App\Models\Payment;

class UserPaymentHistoryAction
{
    public static function execute()
    {
        $user = auth()->user()->id;

        return  Payment::where('user_id', '=', "{$user}")->latest()->paginate(10);
    }
}
