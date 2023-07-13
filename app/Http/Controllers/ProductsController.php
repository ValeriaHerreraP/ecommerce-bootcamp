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
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Loggers\Logger;


class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.index')->only('index');
        $this->middleware('can:products.create')->only('create','store');
        $this->middleware('can:products.edit')->only('edit','update');
        $this->middleware('can:products.destroy')->only('destroy');
    }
    
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
        Logger::create_product();

        return redirect()->route('products.index');
    }

    public function edit(Product $product): View
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductsRequest $request, Product $product): RedirectResponse
    {
        ProductUpdateAction::execute($request, $product);
        Logger::update_products_admin($product);

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
        Logger::delete_products($product);
        ProductDeleteAction::execute($product);

        return redirect()->route('products.index');
    }

    public function export_products(): RedirectResponse
    {
        (new ProductsExport)->queue('products'. date('Y-m-d-His'). '.xlsx', 'disk_reports');
        //(new ProductsExport)->queue('products.xlsx', 'disk_reports');
        Logger::export_products_admin();
        
        return redirect()->route('products.index')->with('messag', 'The export was successfully');
       // return Excel::download(new ProductsExport(), 'products.xlsx');
    }

    public function import_products(Request $request): RedirectResponse
    {
       if( $file= $request->file('doc')){
        Excel::import(new ProductsImport, $file);
        Logger::import_products_admin();
        return redirect()->route('products.index')->with('message', 'The import was successfully');
       };

       return redirect()->route('products.index')->with('message', 'Attach an excel file');
       
    }
    
}
