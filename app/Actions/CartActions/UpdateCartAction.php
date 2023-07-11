<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class UpdateCartAction
{
    public static function execute(Request $request)
    {
        return Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
             ]
        );
    }
}
