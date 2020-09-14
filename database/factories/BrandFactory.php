<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Brand;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company,
        ];
    }
}
