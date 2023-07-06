<?php

namespace App\Loggers;

use Illuminate\Support\Facades\Log;

class Logger {

    public static function payment_gateway_error(\Exception $error):void
    {
        $user_id = auth()->user()->id;
        Log::error("The user with ID: " . $user_id . " is generated the error when creating the payment session. " . $error->getMessage());
    }

    public static function payment_session_created_successfully():void
    {
        $user_id = auth()->user()->id;
        Log::info("The user with ID: " . $user_id . " the payment session is created successfully. ");
    }

    public static function order_payment_status($status, $order):void
    {
        $user_id = auth()->user()->name;
        Log::info( "The payment status of user with Id" . $user_id . " and order " . $order . " is:  " . $status);
    }



}