<?php

namespace App\Http\Controllers;

use App\Actions\ProductActions\ProductCreateAction;
use App\Actions\ProductActions\ProductDeleteAction;
use App\Actions\ProductActions\ProductListAction;
use App\Actions\ProductActions\ProductUpdateAction;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $product = ProductListAction::execute($search);

        return view('products.index', ['products' => $product]);
    }


    public function create(Product $product): View
    {
        return view('products.create', ['product' => $product]);
    }


    public function store(UpdateProductsRequest $request): RedirectResponse
    {
        ProductCreateAction::execute($request);

        return redirect()->route('products.index');
    }


    public function edit(Product $product): View
    {
        return view('products.edit', ['product' => $product]);
    }


    public function update(UpdateProductsRequest $request, Product $product): RedirectResponse
    {
        ProductUpdateAction::execute($request, $product);

        return redirect()->route('products.index');
    }

    public function update_state_product_enable(Product $product): RedirectResponse
    {
        $product->update(['state' => 0]);

        return redirect()->route('products.index');
    }

    public function update_state_product_disable(Product $product): RedirectResponse
    {
        $product->update(['state' => 1]);

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        ProductDeleteAction::execute($product);
        return redirect()->route('products.index');
    }
    
}
