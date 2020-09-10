<?php

use Faker\Generator as Faker;
use Jskrd\Shop\Models\Country;
use Jskrd\Shop\Models\Zone;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'alpha2' => $faker->countryCode,
        'zone_id' => factory(Zone::class),
    ];
});
