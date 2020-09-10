<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jskrd\Shop\Traits\Identifies;
use Jskrd\Shop\Traits\Slugifies;

class Variant extends Model
{
    use Identifies;
    use Slugifies;

    protected $casts = [
        'price' => 'integer',
        'original_price' => 'integer',
        'delivery_cost' => 'integer',
        'stock' => 'integer',
    ];

    protected $fillable = [
        'name',
        'price',
        'original_price',
        'delivery_cost',
        'sku',
        'stock',
        'option1',
        'option2',
        'option3',
    ];

    public function baskets(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Basket')
            ->using('Jskrd\Shop\Models\BasketVariant')
            ->withPivot('customizations', 'quantity', 'price')
            ->withTimestamps();
    }

    public function discounts(): HasMany
    {
        return $this->hasMany('Jskrd\Shop\Models\Discount');
    }

    public function images(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Image')
            ->using('Jskrd\Shop\Models\ImageProduct')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Models\Product');
    }

    public function zones(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Zone')
            ->using('Jskrd\Shop\Models\VariantZone')
            ->withPivot('delivery_cost')
            ->withTimestamps();
    }
}
