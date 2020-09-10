<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\PaypalPayment;

$factory->define(PaypalPayment::class, function (Faker $faker) {
    return [
        'id' => 'PAY-' . Str::random(24),
    ];
});
