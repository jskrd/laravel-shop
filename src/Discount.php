<?php

namespace Jskrd\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jskrd\Shop\Traits\Endable;
use Jskrd\Shop\Traits\Identifies;
use Jskrd\Shop\Traits\Startable;

class Discount extends Model
{
    use Endable;
    use Identifies;
    use Startable;

    protected $casts = [
        'percent' => 'integer',
        'maximum' => 'integer',
        'limit' => 'integer',
    ];

    protected $fillable = [
        'name',
        'code',
        'percent',
        'maximum',
        'limit',
    ];

    protected $keyType = 'string';

    public function baskets(): HasMany
    {
        return $this->hasMany('Jskrd\Shop\Basket');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Variant');
    }
}
