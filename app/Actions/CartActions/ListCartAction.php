<?php

namespace App\Actions\CartActions;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Darryldecode\Cart\CartCollection;

class ListCartAction
{
    public static function execute(): CartCollection
    {
        return Cart::getContent();
    }
}
