<?php

namespace App\Actions\ProductActions;

class ProductDeleteAction
{
    public static function execute($product): Bool
    {
        return  $product->delete();
    }
}
