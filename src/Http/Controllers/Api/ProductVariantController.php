<?php

namespace Jskrd\Shop\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Variant as VariantResource;
use Jskrd\Shop\Models\Product;

class ProductVariantController extends Controller
{
    public function index(Product $product): JsonResource
    {
        return VariantResource::collection($product->variants);
    }
}
