<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop(Request $request)
    {
        //muestra los productos
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->orWhere('price', '<=', "{$search}")->paginate(6);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart()
    {
        //Se muestran los productos añadidos
        $cartCollection = \Cart::getContent();
        //dd($cartCollection);
        return view('cart.cart', ['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request)
    {
        //Elimina el producto seleccionado
        \Cart::remove($request->id);

        return redirect()->route('cart.index');
    }

    public function add(Request $request)
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

    public function update(Request $request)
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

    public function clear()
    {
        //Elimina todos los elementos del carrito
        \Cart::clear();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }

  /*  public function uu (Request $request)
    {


        \Cart::add(array(
            'id' => 456, // inique row ID
            'name' => 'Sample Item',
            'price' => 67.99,
            'quantity' => 4,
            'attributes' => array()
        ));

        \Cart::update(456, array(
            'name' => 'New Item Name', // new item name
            'price' => 98.67, // new item price, price can also be a string format like so: '98.67'
          ));

          \Cart::remove(456);

        $cartCollection = \Cart::getContent();
        dd($cartCollection);


        return view('productos', ['products' => $product]);

    }

    public function cart()  {

        $cartCollection = \Cart::getContent();
        dd($cartCollection);

        return view('cart');
    }
    */
}
