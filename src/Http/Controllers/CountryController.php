<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Country;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Country as CountryResource;

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
