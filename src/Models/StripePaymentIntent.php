<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class StripePaymentIntent extends Model
{
    protected $fillable = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function order()
    {
        return $this->morphOne('Jskrd\Shop\Models\Order', 'paymentable');
    }
}
