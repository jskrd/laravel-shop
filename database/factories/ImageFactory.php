<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Image;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'path' => Str::random() . '.png',
            'width' => rand(100, 2000),
            'height' => rand(100, 2000),
            'size' => rand(1000, 1000000),
        ];
    }
}
