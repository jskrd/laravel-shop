<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jskrd\Shop\Traits\Identifies;

class Image extends Model
{
    use Identifies;

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
    ];

    protected $fillable = [
        'path',
        'width',
        'height',
        'size',
    ];

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Product')
            ->using('Jskrd\Shop\Models\ImageProduct')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function variants(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Variant')
            ->using('Jskrd\Shop\Models\ImageVariant')
            ->withPivot('position')
            ->withTimestamps();
    }
}
