<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Zone;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(255),
        ];
    }
}
