<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return ProductResource::collection($this->productService->getAll());
    }

    public function store(Request $request)
    {
        $product = $this->productService->store($request);
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($this->productService->getById($product));
    }

    public function update(Request $request, Product $product)
    {
        return new ProductResource($this->productService->update($request, $product));
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
