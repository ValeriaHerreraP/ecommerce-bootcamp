<?php

namespace App\Actions\CartActions;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class UpdateCartAction
{
    public static function execute(Request $request): Bool
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
