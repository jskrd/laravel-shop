<?php

namespace Database\Factories;

use Carbon\Carbon;
use Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ucwords($this->faker->unique()->words(rand(1, 3), true)),
            'options1' => ucfirst($this->faker->word),
            'options2' => ucfirst($this->faker->word),
            'options3' => ucfirst($this->faker->word),
            'brand_id' => rand(0, 1) === 1 ? BrandFactory::new() : null,
            'started_at' => Carbon::now(),
            'ended_at' => null,
        ];
    }
}
