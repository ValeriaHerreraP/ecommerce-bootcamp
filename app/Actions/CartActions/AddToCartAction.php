<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class AddToCartAction
{
    public static function execute(Request $request)
    {
        return Cart::add([
           'id' => $request->id,
           'name' => $request->name,
           'price' => $request->price,
           'quantity' => $request->quantity,
           'attributes' => [
        'image' => $request->img,
        ],
        ]);
    }
}
