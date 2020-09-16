<?php

namespace Jskrd\Shop\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Requests\StoreBasketVariant;
use Jskrd\Shop\Http\Requests\UpdateBasketVariant;
use Jskrd\Shop\Http\Resources\Variant as VariantResource;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Variant;

class BasketVariantController extends Controller
{
    public function index(Basket $basket): JsonResource
    {
        return VariantResource::collection($basket->variants);
    }

    public function store(
        Basket $basket,
        StoreBasketVariant $request
    ): JsonResource {
        $validated = $request->validated();

        abort_if(
            $basket->variants->contains(function ($variant) use ($validated) {
                $pivot = $variant->pivot;

                return $pivot->variant_id === $validated['variant_id'] &&
                    $pivot->customizations === $validated['customizations'];
            }),
            409
        );

        $variant = Variant::find($validated['variant_id']);

        $basket->variants()->attach($variant, array_merge($validated, [
            'price' => $variant->price,
        ]));

        return new VariantResource($basket->variants()->find($variant));
    }

    public function show(Basket $basket, Variant $variant): JsonResource
    {
        return new VariantResource($basket->variants()->find($variant));
    }

    public function update(
        Basket $basket,
        Variant $variant,
        UpdateBasketVariant $request
    ): JsonResource {
        $validated = $request->validated();

        abort_unless($basket->variants->contains($variant), 404);

        $basket->variants()->updateExistingPivot($variant, $validated);

        return new VariantResource($basket->variants()->find($variant));
    }

    public function destroy(Basket $basket, Variant $variant): JsonResource
    {
        $basket->variants()->detach($variant);

        return VariantResource::collection($basket->variants);
    }
}
