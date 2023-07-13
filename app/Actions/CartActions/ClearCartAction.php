<?php

namespace App\Actions\CartActions;

use Darryldecode\Cart\Facades\CartFacade as Cart;

class ClearCartAction
{
    public static function execute(): Bool
    {
        return Cart::clear();
    }
}
