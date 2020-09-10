<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Address;

$factory->define(Address::class, function (Faker $faker) {
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'street1' => $faker->buildingNumber . ' ' . $faker->streetName,
        'street2' => $faker->secondaryAddress,
        'locality' => $faker->city,
        'region' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->countryCode,
        'email' => Str::slug($name) . '@example.com',
        'phone' => $faker->e164PhoneNumber,
    ];
});
