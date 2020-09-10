<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jskrd\Shop\Traits\Identifies;

class Zone extends Model
{
    use Identifies;

    protected $fillable = [
        'name',
    ];

    public function countries(): HasMany
    {
        return $this->hasMany('Jskrd\Shop\Models\Country');
    }

    public function variants(): BelongsToMany
    {
        return $this
            ->belongsToMany('Jskrd\Shop\Models\Variant')
            ->using('Jskrd\Shop\Models\VariantZone')
            ->withPivot('delivery_cost')
            ->withTimestamps();
    }
}
