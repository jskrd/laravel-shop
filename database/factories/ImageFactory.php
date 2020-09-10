<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Image;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'path' => Str::random() . '.png',
        'width' => rand(100, 2000),
        'height' => rand(100, 2000),
        'size' => rand(1000, 1000000),
    ];
});
