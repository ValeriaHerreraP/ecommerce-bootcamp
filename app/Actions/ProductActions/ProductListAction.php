<?php

namespace App\Actions\ProductActions;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductListAction
{
    public static function execute($search): LengthAwarePaginator
    {
        return Product::where('product', 'LIKE', "%{$search}%")->paginate(10);
    }
}
