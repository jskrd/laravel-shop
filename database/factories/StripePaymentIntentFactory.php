<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\StripePaymentIntent;

class StripePaymentIntentFactory extends Factory
{
    protected $model = StripePaymentIntent::class;

    public function definition(): array
    {
        return [
            'id' => 'pi_' . Str::random(24),
        ];
    }
}
