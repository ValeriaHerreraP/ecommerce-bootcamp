<?php

namespace App\Loggers;

use Illuminate\Support\Facades\Log;

class Logger
{
    public static function payment_gateway_error(\Exception $error):void
    {
        $user_id = auth()->user()->id;
        Log::error('The user with ID: '.$user_id.' is generated the error when creating the payment session. '.$error->getMessage());
    }

    public static function payment_session_created_successfully():void
    {
        $user_id = auth()->user()->id;
        Log::info('The user with ID: '.$user_id.' the payment session is created successfully. ');
    }

    public static function order_payment_status($status, $order):void
    {
        $user_id = auth()->user()->id;
        Log::info('The payment status of user with Id '.$user_id.' and order '.$order.' is:  '.$status);
    }

    public static function update_users_admin($user):void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.' successfully update the User with ID: '.$user->id);
    }

    public static function update_users_state($user):void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully update the state User with ID: '.$user->id);
    }

    public static function delete_users($user):void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully update the state User with ID: '.$user->id);
    }

    public static function create_product():void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.' successfully create the product.');
    }

    public static function update_products_admin($product):void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully update the product with ID: '.$product->id);
    }

    public static function delete_products($product):void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully delete the product with ID: '.$product->id);
    }

    public static function export_products_admin():void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully exported the products');
    }

    public static function import_products_admin():void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully imported the products');
    }

    public static function delete_and_import_products_admin():void
    {
        $user_name = auth()->user()->name;
        Log::info('The user administrator '.$user_name.'successfully deleted and imported the products');
    }
}
