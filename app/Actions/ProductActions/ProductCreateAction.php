<?php

namespace App\Actions\ProductActions;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCreateAction
{
    public static function execute(Request $request)
    {
        $product = $request->all();

        if ($image = $request->file('image')->store('public/image')) {
            $url = Storage::url($image);
            $product['image'] = $url;
        }

        return Product::create($product);
    }
}
