<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\StripePaymentIntent;

$factory->define(StripePaymentIntent::class, function (Faker $faker) {
    return [
        'id' => 'pi_' . Str::random(24),
    ];
});
