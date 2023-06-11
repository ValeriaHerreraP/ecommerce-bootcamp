<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function productos(Request $request): View
    {
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);

        return view('productos', ['products' => $product]);
    }
}
