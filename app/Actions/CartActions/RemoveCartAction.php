<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class RemoveCartAction
{
    public static function execute(Request $request): Bool
    {
        return Cart::remove($request->id);
    }
}
