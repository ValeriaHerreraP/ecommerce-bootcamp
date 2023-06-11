<?php

namespace App\Actions;

use App\Models\Payment;

class UserOrderAction
{
    public static function execute()
    {
        $user = auth()->user()->id;
        return  Payment::where('user_id', '=', "{$user}")->paginate(10);
    }
}