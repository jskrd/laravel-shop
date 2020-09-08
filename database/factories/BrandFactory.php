<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Brand;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
    ];
});
