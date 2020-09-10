<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Models\Address;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Discount;

$factory->define(Basket::class, function (Faker $faker) {
    return [
        'discount_amount' => rand(100, 1000),
        'delivery_cost' => rand(100, 1000),
        'billing_address_id' => factory(Address::class),
        'delivery_address_id' => factory(Address::class),
        'discount_id' => factory(Discount::class),
    ];
});
