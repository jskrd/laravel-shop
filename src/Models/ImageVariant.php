<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ImageVariant extends Pivot
{
    protected $casts = [
        'position' => 'integer',
    ];
}
