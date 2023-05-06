<?php

namespace App\Http\Controllers;
use App\Models\products;

use Illuminate\Http\Request;

class PageController extends Controller
{
public function productos(Request $request)
    {
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%") -> orWhere ('price', '<=', "{$search}") ->paginate(5);

        return view('productos', ['products' => $product]);
    }
}   