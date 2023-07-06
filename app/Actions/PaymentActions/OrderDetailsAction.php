<?php

namespace App\Actions\PaymentActions;
use App\Models\OrderDetail;


class OrderDetailsAction
{
    public static function execute($order)
    {
        $cartCollection = \Cart::getContent();

        foreach ($cartCollection as $items) {
            $subtotal = ($items->price * $items->quantity);

            
             OrderDetail::create([
                'user_id' => auth()->id(),
                'order_id'=> $order->id,
                'name'=> $items->name,
                'price'=> $items->price,
                'quantity'=>$items->quantity,
                'subtotal' =>$subtotal,
                'total'=> \Cart::getTotal(),
                ]);
        }

        return  \Cart::clear();
        
    }
}