<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\V1\ProductResourse;
use App\Actions\ProductActions\ProductCreateAction;
use App\Actions\ProductActions\ProductUpdateAction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class ProductsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResourse::collection(Product::latest()->paginate()) ;
        
    }

    public function store(Request $request): JsonResponse
    {
        $product = ProductCreateAction::execute($request);

        return response()->json([
            'message' => 'The product was created successfully',
            'data' => new ProductResourse($product),
        ], 201);
        
    }

    public function show(Product $product): ProductResourse
    {
        return new ProductResourse($product);

    }

    /*public function get_product_by_name(Product $product): ProductResourse
    {
        return new ProductResourse($product->name);

    }
    */

    public function update(Request $request, Product $product): JsonResponse
    {
        ProductUpdateAction::execute($request, $product);

        return response()->json([
            'message' => 'The product was updated successfully',
        ], 200);
    
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(
            [
                'message' => 'The product was deleted successfully'
            ], 204
            );
    }
}
