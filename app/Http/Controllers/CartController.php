<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop(Request $request): View
    {
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart(): View
    {
        $cartCollection = \Cart::getContent();

        return view('cart.cart', ['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request): RedirectResponse
    {
        \Cart::remove($request->id);

        return redirect()->route('cart.index');
    }

    public function add(Request $request): RedirectResponse
    {
        \Cart::add([
             'id' => $request->id,
             'name' => $request->name,
             'price' => $request->price,
             'quantity' => $request->quantity,
             'attributes' => [
                 'image' => $request->img,
          ],
         ]);

        return redirect()->route('cart.index');
    }

    public function update(Request $request): RedirectResponse
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
             ]
        );

        return redirect()->route('cart.index');
    }

    public function clear(): RedirectResponse
    {
        \Cart::clear();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }
}
