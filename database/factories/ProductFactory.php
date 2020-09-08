<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Jskrd\Shop\Brand;
use Jskrd\Shop\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->unique()->words(rand(1, 3), true)),
        'options1' => ucfirst($faker->word),
        'options2' => ucfirst($faker->word),
        'options3' => ucfirst($faker->word),
        'brand_id' => rand(0, 1) === 1 ? factory(Brand::class) : null,
        'started_at' => Carbon::now(),
        'ended_at' => null,
    ];
});
