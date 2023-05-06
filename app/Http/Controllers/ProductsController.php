<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $product = products::where('product', 'LIKE', "%{$search}%")->paginate(5);
        return view('products.index', ['products' => $product]);
    }

    
    public function create(products $product)
    {
        return view('products.create',['product' => $product]);
    }

    
    public function store(Request $request)
    {
        $product = $request -> all();

        if($image = $request->file('image')->store('public/image')){
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

   
    public function edit(products $product)
    {
        return view('products.edit',['product' => $product]);
    }

   
    public function update(Request $request, products $product)
    {
        $request->validate([
            'product'=>'required',
            'price'=>'required',
            'description'=>'required',
        ]);

        $prod = $request -> all();

        if($image = $request->file('image')->store('public/image')){
            $url = Storage::url($image);
           $prod['image'] = $url;
        }else{
            unset($prod['image']);
        }
        $product->update($prod);

        return redirect()->route('products.index');
    }
 
    public function destroy(products $product)
    {
        $product->delete();
        return back();
    }
}