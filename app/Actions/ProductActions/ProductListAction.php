<?php

namespace App\Actions\ProductActions;

use App\Models\Product;

class ProductListAction
{
    public static function execute($search)
    {
        return Product::where('product', 'LIKE', "%{$search}%")->paginate(5);
    }
}
