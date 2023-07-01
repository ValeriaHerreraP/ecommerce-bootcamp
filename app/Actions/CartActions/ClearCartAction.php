<?php

namespace App\Actions\CartActions;

use Illuminate\Http\Request;

class ClearCartAction
{
    public static function execute()
    {
        return \Cart::clear();
    }
}
