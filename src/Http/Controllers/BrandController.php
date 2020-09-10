<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Brand as BrandResource;
use Jskrd\Shop\Models\Brand;

class BrandController extends Controller
{
    public function index(): JsonResource
    {
        return BrandResource::collection(Brand::all());
    }

    public function show(Brand $brand): JsonResource
    {
        return new BrandResource($brand);
    }
}
