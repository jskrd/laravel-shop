<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\PaypalPayment;

class PaypalPaymentFactory extends Factory
{
    protected $model = PaypalPayment::class;

    public function definition(): array
    {
        return [
            'id' => 'PAY-' . Str::random(24),
        ];
    }
}
