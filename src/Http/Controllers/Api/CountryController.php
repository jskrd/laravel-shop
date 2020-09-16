<?php

namespace Jskrd\Shop\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Country as CountryResource;
use Jskrd\Shop\Models\Country;

class CountryController extends Controller
{
    public function index(): JsonResource
    {
        return CountryResource::collection(Country::all());
    }

    public function show(Country $country): JsonResource
    {
        return new CountryResource($country);
    }
}
