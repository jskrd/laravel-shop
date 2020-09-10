<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ImageProduct extends Pivot
{
    protected $casts = [
        'position' => 'integer',
    ];
}
