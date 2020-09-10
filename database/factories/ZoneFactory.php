<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Models\Zone;

$factory->define(Zone::class, function (Faker $faker) {
    return [
        'name' => $faker->text(255),
    ];
});
