<?php

namespace App\Http\Controllers;

use App\Actions\CartActions\AddToCartAction;
use App\Actions\CartActions\ClearCartAction;
use App\Actions\CartActions\ListCartAction;
use App\Actions\CartActions\RemoveCartAction;
use App\Actions\CartActions\SearchCartAction;
use App\Actions\CartActions\UpdateCartAction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop(Request $request): View
    {
        $search = $request->search;
        $product = SearchCartAction::execute($search);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart(): View
    {
        $cartCollection = ListCartAction::execute();

        return view('cart.cart', ['cartCollection' => $cartCollection]);
    }

    public function remove(Request $request): RedirectResponse
    {
        RemoveCartAction::execute($request);
        return redirect()->route('cart.index');
    }

    public function add(Request $request): RedirectResponse
    {
        AddToCartAction::execute($request);

        return redirect()->route('cart.index');
    }

    public function update(Request $request): RedirectResponse
    {
        UpdateCartAction::execute($request);

        return redirect()->route('cart.index');
    }

    public function clear(): RedirectResponse
    {
        ClearCartAction::execute();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }
}
