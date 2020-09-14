<?php

namespace Database\Factories;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Variant;

class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition(): array
    {
        return [
            'name' => ucwords($this->faker->unique()->words(rand(1, 3), true)),
            'price' => rand(100, 10000),
            'original_price' => rand(0, 1) === 1 ? rand(100, 10000) : null,
            'delivery_cost' => rand(100, 1000),
            'sku' => $this->faker->ean13,
            'stock' => rand(0, 1) === 1 ? rand(1, 10) : null,
            'option1' => ucfirst($this->faker->word),
            'option2' => ucfirst($this->faker->word),
            'option3' => ucfirst($this->faker->word),
            'product_id' => ProductFactory::new(),
        ];
    }
}
