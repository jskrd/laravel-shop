<?php

namespace Jskrd\Shop\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Image as ImageResource;
use Jskrd\Shop\Models\Variant;

class VariantImageController extends Controller
{
    public function index(Variant $variant): JsonResource
    {
        return ImageResource::collection($variant->images);
    }
}
