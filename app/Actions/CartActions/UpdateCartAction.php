<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;

class UpdateCartAction
{
    public static function execute(Request $request)
    {
        return \Cart::update(
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
