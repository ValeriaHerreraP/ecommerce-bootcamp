<?php

namespace App\Actions\CartActions;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class RemoveCartAction
{
    public static function execute(Request $request): Bool
    {
        return Cart::remove($request->id);
    }
}
