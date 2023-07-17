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
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cart.shop')->only('shop');
        $this->middleware('can:cart.index')->only('cart');
        $this->middleware('can:cart.store')->only('add_products_cart');
        $this->middleware('can:cart.update')->only('update');
        $this->middleware('can:cart.remove')->only('remove_item_cart');
        $this->middleware('can:cart.clear')->only('clear_cart');
    }

    public function shop(Request $request): View
    {
        $search = $request->search;
        if ($search == null) {
            $search = '';
        }
        $product = SearchCartAction::execute($search);

        return view('cart.shop', ['products' => $product]);
    }

    public function cart(): View
    {
        $cartCollection = ListCartAction::execute();

        return view('cart.index', ['cartCollection' => $cartCollection]);
    }

    public function remove_item_cart(Request $request): RedirectResponse
    {
        RemoveCartAction::execute($request);

        return redirect()->route('cart.index');
    }

    public function add_products_cart(Request $request): RedirectResponse
    {
        AddToCartAction::execute($request);

        return redirect()->route('cart.index');
    }

    public function update(Request $request): RedirectResponse
    {
        UpdateCartAction::execute($request);

        return redirect()->route('cart.index');
    }

    public function clear_cart(): RedirectResponse
    {
        ClearCartAction::execute();

        return redirect()->route('cart.index')->with('success_msg', 'Carrito sin productos.');
    }
}
