<?php

namespace Jskrd\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Basket extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'variants_count' => $this->variants_count,
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discount_amount,
            'delivery_cost' => $this->delivery_cost,
            'total' => $this->total,
            'billing_address_id' => $this->billing_address_id,
            'delivery_address_id' => $this->delivery_address_id,
            'discount_id' => $this->discount_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
