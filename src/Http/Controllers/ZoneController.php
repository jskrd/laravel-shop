<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Zone as ZoneResource;
use Jskrd\Shop\Models\Zone;

class ZoneController extends Controller
{
    public function index(): JsonResource
    {
        return ZoneResource::collection(Zone::all());
    }

    public function show(Zone $zone): JsonResource
    {
        return new ZoneResource($zone);
    }
}
