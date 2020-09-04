<?php

namespace Jskrd\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Jskrd\Shop\Traits\Identifies;

class Basket extends Model
{
    use Identifies;

    protected $attributes = [
        'discount_amount' => 0,
        'delivery_cost' => 0,
    ];

    protected $casts = [
        'discount_amount' => 'integer',
        'delivery_cost' => 'integer',
    ];

    protected $fillable = [
        'billing_address_id',
        'delivery_address_id',
        'discount_id',
    ];

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Address');
    }

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Address');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Discount');
    }

    public function calculateDeliveryCost(): int
    {
        if ($this->deliveryAddress === null) {
            return 0;
        }

        $cost = 0;

        foreach ($this->variants as $variant) {
            $zoneCost = null;

            foreach ($variant->zones as $zone) {
                if ($zone->countries->keyBy('alpha2')->has($this->deliveryAddress->country)) {
                    $zoneCost = $zone->pivot->delivery_cost;
                }
            }

            $cost += ($zoneCost ?? $variant->delivery_cost) * $variant->pivot->quantity;
        }

        return $cost;
    }

    public function calculateDiscountAmount(): int
    {
        if ($this->discount === null) {
            return 0;
        }

        $from = $this->subtotal;
        $maximum = $this->discount->maximum ?? $this->subtotal;

        if ($this->discount->variant_id !== null) {
            $variant = $this->variants->find($this->discount->variant_id);

            if ($variant === null) {
                return 0;
            }

            $from = $variant->pivot->price * $variant->pivot->quantity;
            $maximum = $this->discount->maximum ?? $variant->pivot->price * $variant->pivot->quantity;
        }

        $amount = round(($from / 100) * $this->discount->percent);

        return $amount <= $maximum ? $amount : $maximum;
    }

    public function getSubtotalAttribute(): int
    {
        $subtotal = 0;

        foreach ($this->variants as $variant) {
            $subtotal += $variant->pivot->price * $variant->pivot->quantity;
        }

        return $subtotal;
    }

    public function getTotalAttribute(): int
    {
        return ($this->subtotal - $this->discount_amount) +
            $this->delivery_cost;
    }

    public function order(): HasOne
    {
        return $this->hasOne('Jskrd\Shop\Order');
    }

    public function variants(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Variant')
            ->using('Jskrd\Shop\BasketVariant')
            ->withPivot('customizations', 'quantity', 'price')
            ->withTimestamps();
    }
}
