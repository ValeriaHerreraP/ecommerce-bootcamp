<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class CartController extends Controller
{
    public function shop(Request $request): View
    {
        //muestra los productos
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart(): View
    {
        //Se muestran los productos añadidos
        $cartCollection = \Cart::getContent();

        return view('cart.cart', ['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request): RedirectResponse
    {
        //Elimina el producto seleccionado
        \Cart::remove($request->id);

        return redirect()->route('cart.index');
    }

    public function add(Request $request): RedirectResponse
    {
        //añade el producto al carrito
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
        //Modifica la cantidad
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
        //Elimina todos los elementos del carrito
        \Cart::clear();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }

}
    
