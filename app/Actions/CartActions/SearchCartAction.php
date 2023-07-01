<?php

namespace App\Actions\CartActions;

use App\Models\Product;

class SearchCartAction
{
    public static function execute($search)
    {
        return Product::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);
    }
}
