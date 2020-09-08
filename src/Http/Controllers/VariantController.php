<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Variant as VariantResource;
use Jskrd\Shop\Variant;

class VariantController extends Controller
{
    public function index(): JsonResource
    {
        return VariantResource::collection(Variant::paginate(24));
    }

    public function show(Variant $variant): JsonResource
    {
        return new VariantResource($variant);
    }
}
