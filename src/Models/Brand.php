<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jskrd\Shop\Traits\Identifies;
use Jskrd\Shop\Traits\Slugifies;

class Brand extends Model
{
    use Identifies;
    use Slugifies;

    protected $fillable = [
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany('Jskrd\Shop\Models\Product');
    }
}
