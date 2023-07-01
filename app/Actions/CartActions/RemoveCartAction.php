<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;

class RemoveCartAction
{
    public static function execute(Request $request)
    {
        return \Cart::remove($request->id);
    }
}
