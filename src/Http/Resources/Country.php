<?php

namespace Jskrd\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Country extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'alpha2' => $this->alpha2,
            'zone_id' => $this->zone_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
