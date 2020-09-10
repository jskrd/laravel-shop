<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Image as ImageResource;
use Jskrd\Shop\Models\Product;

class ProductImageController extends Controller
{
    public function index(Product $product): JsonResource
    {
        return ImageResource::collection($product->images);
    }
}
