<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Address;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->name;

        return [
            'name' => $name,
            'street1' => $this->faker->buildingNumber . ' ' . $this->faker->streetName,
            'street2' => $this->faker->secondaryAddress,
            'locality' => $this->faker->city,
            'region' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->countryCode,
            'email' => Str::slug($name) . '@example.com',
            'phone' => $this->faker->e164PhoneNumber,
        ];
    }
}
