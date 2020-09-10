<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Models\Product;
use Jskrd\Shop\Models\Variant;

$factory->define(Variant::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true)),
        'price' => rand(100, 10000),
        'original_price' => rand(0, 1) === 1 ? rand(100, 10000) : null,
        'delivery_cost' => rand(100, 1000),
        'sku' => $faker->ean13,
        'stock' => rand(0, 1) === 1 ? rand(1, 10) : null,
        'option1' => ucfirst($faker->word),
        'option2' => ucfirst($faker->word),
        'option3' => ucfirst($faker->word),
        'product_id' => factory(Product::class),
    ];
});
