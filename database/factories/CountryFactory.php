<?php

namespace Database\Factories;

use Database\Factories\ZoneFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jskrd\Shop\Models\Country;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'alpha2' => $this->faker->countryCode,
            'zone_id' => ZoneFactory::new(),
        ];
    }
}
