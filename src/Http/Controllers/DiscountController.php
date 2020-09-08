<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Discount;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Requests\IndexDiscount;
use Jskrd\Shop\Http\Resources\Discount as DiscountResource;

class DiscountController extends Controller
{
    public function index(IndexDiscount $request): JsonResource
    {
        $validated = $request->validated();

        return DiscountResource::collection(
            Discount::where('code', $validated['code'])->get()
        );
    }

    public function show(Discount $discount): JsonResource
    {
        return new DiscountResource($discount);
    }
}
