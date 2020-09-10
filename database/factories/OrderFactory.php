<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Order;
use Jskrd\Shop\Models\StripePaymentIntent;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'basket_id' => factory(Basket::class),
        'paymentable_id' => factory(StripePaymentIntent::class),
        'paymentable_type' => 'Jskrd\Shop\Models\StripePaymentIntent',
    ];
});
