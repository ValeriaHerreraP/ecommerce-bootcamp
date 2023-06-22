<?php

namespace App\Actions\CartActions;


class ListCartAction
{       
    public static function execute()
    {
        return \Cart::getContent();;
    }
}
