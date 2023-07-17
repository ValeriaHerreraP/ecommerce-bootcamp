<?php

namespace App\Actions\ProductActions;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductUpdateAction
{
    public static function execute(Request $request, Product $product): Bool
    {
        $data = $request->all();

        if ($image = $request->file('image')) {
            $img = $image->store('public/image');
            $url = Storage::url($img);
            $data['image'] = $url;
        } else {
            unset($data['image']);
        }

        return $product->update($data);
    }
}
