<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BasketVariant extends Pivot
{
    protected $casts = [
        'customizations' => 'array',
        'quantity' => 'integer',
        'price' => 'integer',
    ];
}
