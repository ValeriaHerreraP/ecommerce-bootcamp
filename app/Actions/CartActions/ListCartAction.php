<?php

namespace App\Actions\CartActions;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ListCartAction
{
    public static function execute()
    {
        return Cart::getContent();
    }
}
