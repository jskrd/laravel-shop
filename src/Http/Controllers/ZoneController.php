<?php

namespace Jskrd\Shop\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Jskrd\Shop\Zone;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Http\Resources\Zone as ZoneResource;

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
