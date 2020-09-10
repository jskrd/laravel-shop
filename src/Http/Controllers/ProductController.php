<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Product as ProductResource;
use Jskrd\Shop\Models\Product;

class ProductController extends Controller
{
    public function index(): JsonResource
    {
        return ProductResource::collection(Product::paginate(24));
    }

    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }
}
