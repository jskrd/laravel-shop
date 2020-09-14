<?php

namespace Database\Factories;

use Database\Factories\BasketFactory;
use Database\Factories\StripePaymentIntentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'basket_id' => BasketFactory::new(),
            'paymentable_id' => StripePaymentIntentFactory::new(),
            'paymentable_type' => 'Jskrd\Shop\Models\StripePaymentIntent',
        ];
    }
}
