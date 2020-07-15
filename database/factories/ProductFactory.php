<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->words(rand(1, 3), true)),
        'options1' => ucfirst($faker->word),
        'options2' => ucfirst($faker->word),
        'options3' => ucfirst($faker->word),
    ];
});
