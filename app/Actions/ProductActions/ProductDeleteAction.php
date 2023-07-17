<?php

namespace App\Actions\ProductActions;

use App\Models\Product;

class ProductDeleteAction
{
    public static function execute(Product $product): Bool
    {
        return  $product->delete();
    }
}
