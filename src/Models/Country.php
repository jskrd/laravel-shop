<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jskrd\Shop\Traits\Identifies;

class Country extends Model
{
    use Identifies;

    protected $fillable = [
        'alpha2',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo('Jskrd\Shop\Models\Zone');
    }
}
