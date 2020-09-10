<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VariantZone extends Pivot
{
    protected $casts = [
        'delivery_cost' => 'integer',
    ];
}
