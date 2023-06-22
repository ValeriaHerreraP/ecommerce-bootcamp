<?php

namespace App\Actions\ProductActions;

class ProductDeleteAction
{
    public static function execute($product)
    {
        return  $product->delete();
    }
}