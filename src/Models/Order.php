<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Jskrd\Shop\Traits\Identifies;

class Order extends Model
{
    use Identifies;

    public function basket(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Models\Basket');
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }
}
