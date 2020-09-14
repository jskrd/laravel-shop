<?php

namespace Database\Factories;

use Database\Factories\VariantFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Discount;

class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->unique()->word,
            'percent' => rand(10, 100),
            'maximum' => rand(0, 1) === 1 ? rand(1, 10) * 100 : null,
            'limit' => rand(0, 1) === 1 ? rand(1, 10000) : null,
            'variant_id' => rand(0, 1) === 1 ? VariantFactory::new() : null,
            'started_at' => Carbon::now()->startOfWeek(),
            'ended_at' => Carbon::now()->endOfWeek(),
        ];
    }
}
