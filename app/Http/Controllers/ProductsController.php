<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->paginate(5);

        return view('products.index', ['products' => $product]);
    }

    public function create(products $product): View
    {
        return view('products.create', ['product' => $product]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = $request->all();

        if ($image = $request->file('image')->store('public/image')) {
            $url = Storage::url($image);
            $product['image'] = $url;
        }

        products::create($product);

        return redirect()->route('products.index');
    }

    public function show(products $products)
    {
        //
    }

    public function edit(products $product): View
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductsRequest $request, products $product): RedirectResponse
    {
        $prod = $request->all();

        if ($image = $request->file('image')->store('public/image')) {
            $url = Storage::url($image);
            $prod['image'] = $url;
        } else {
            unset($prod['image']);
        }
        $product->update($prod);

        return redirect()->route('products.index');
    }

    public function updateState(Request $request, Products $product)
    {
        if ($request->state == 'Habilitar') {
            $state = 1;
        } else {
            $state = 0;
        }

        $product->update([
            'state' => $state,
        ]);

        return back();
    }

    public function destroy(products $product)
    {
        $product->delete();

        return back();
    }
}
