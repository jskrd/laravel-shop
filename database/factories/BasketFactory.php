<?php

namespace Database\Factories;

use Database\Factories\AddressFactory;
use Database\Factories\DiscountFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Basket;

class BasketFactory extends Factory
{
    protected $model = Basket::class;

    public function definition(): array
    {
        return [
            'discount_amount' => rand(100, 1000),
            'delivery_cost' => rand(100, 1000),
            'billing_address_id' => AddressFactory::new(),
            'delivery_address_id' => AddressFactory::new(),
            'discount_id' => DiscountFactory::new(),
        ];
    }
}
