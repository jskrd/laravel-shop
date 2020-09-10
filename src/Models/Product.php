<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jskrd\Shop\Traits\Endable;
use Jskrd\Shop\Traits\Identifies;
use Jskrd\Shop\Traits\Slugifies;
use Jskrd\Shop\Traits\Startable;

class Product extends Model
{
    use Endable;
    use Identifies;
    use Slugifies;
    use Startable;

    protected $fillable = [
        'name',
        'options1',
        'options2',
        'options3',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Models\Brand');
    }

    public function images(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Image')
            ->using('Jskrd\Shop\Models\ImageProduct')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function variants(): HasMany
    {
        return $this->hasMany('Jskrd\Shop\Models\Variant');
    }
}
