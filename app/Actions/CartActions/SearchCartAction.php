<?php

namespace App\Actions\CartActions;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SearchCartAction
{
    public static function execute(string $search): LengthAwarePaginator
    {
        return Product::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(15);
    }
}
