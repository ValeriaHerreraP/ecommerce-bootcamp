<?php

namespace App\Actions\CartActions;

use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ListCartAction
{
    public static function execute(): CartCollection
    {
        return Cart::getContent();
    }
}
