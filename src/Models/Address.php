<?php

namespace Jskrd\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Jskrd\Shop\Traits\Identifies;

class Address extends Model
{
    use Identifies;

    protected $fillable = [
        'name',
        'street1',
        'street2',
        'locality',
        'region',
        'postal_code',
        'country',
        'email',
        'phone',
    ];

    public function basketBilling(): HasOne
    {
        return $this->hasOne('Jskrd\Shop\Models\Basket', 'billing_address_id');
    }

    public function basketDelivery(): HasOne
    {
        return $this->hasOne('Jskrd\Shop\Models\Basket', 'delivery_address_id');
    }
}
