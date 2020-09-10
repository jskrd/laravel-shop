<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Requests\StoreAddress;
use Jskrd\Shop\Http\Requests\UpdateAddress;
use Jskrd\Shop\Http\Resources\Address as AddressResource;
use Jskrd\Shop\Models\Address;

class AddressController extends Controller
{
    public function store(StoreAddress $request): JsonResource
    {
        $validated = $request->validated();

        $address = Address::create($validated);

        return new AddressResource($address);
    }

    public function show(Address $address): JsonResource
    {
        return new AddressResource($address);
    }

    public function update(Address $address, UpdateAddress $request): JsonResource
    {
        $validated = $request->validated();

        $address->update($validated);

        return new AddressResource($address);
    }

    public function destroy(Address $address): JsonResource
    {
        $address->delete();

        return new AddressResource($address);
    }
}
