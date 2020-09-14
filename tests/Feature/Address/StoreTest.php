<?php

namespace Tests\Feature\Address;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Address;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(url('/shop-api/addresses'), route('addresses.store'));
    }

    public function testNameRequired(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'name' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.'
            ]);
    }

    public function testNameString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'name' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name must be a string.'
            ]);
    }

    public function testNameMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'name' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name may not be greater than 255 characters.'
            ]);
    }

    public function testStreet1Required(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street1' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 field is required.'
            ]);
    }

    public function testStreet1String(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street1' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 must be a string.'
            ]);
    }

    public function testStreet1Max(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street1' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 may not be greater than 255 characters.'
            ]);
    }

    public function testStreet2Nullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street2' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('street2');
    }

    public function testStreet2String(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street2' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street2' => 'The street2 must be a string.'
            ]);
    }

    public function testStreet2Max(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'street2' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street2' => 'The street2 may not be greater than 255 characters.'
            ]);
    }

    public function testLocalityNullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'locality' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('locality');
    }

    public function testLocalityString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'locality' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'locality' => 'The locality must be a string.'
            ]);
    }

    public function testLocalityMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'locality' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'locality' => 'The locality may not be greater than 255 characters.'
            ]);
    }

    public function testRegionNullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'region' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('region');
    }

    public function testRegionString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'region' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'region' => 'The region must be a string.'
            ]);
    }

    public function testRegionMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'region' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'region' => 'The region may not be greater than 255 characters.'
            ]);
    }

    public function testPostalCodeNullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'postal_code' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('postal_code');
    }

    public function testPostalCodeString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'postal_code' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'postal_code' => 'The postal code must be a string.'
            ]);
    }

    public function testPostalCodeMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'postal_code' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'postal_code' => 'The postal code may not be greater than 255 characters.'
            ]);
    }

    public function testCountryRequired(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'country' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country field is required.'
            ]);
    }

    public function testCountryString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'country' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country must be 2 characters.'
            ]);
    }

    public function testCountrySize(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'country' => 'GBR',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country must be 2 characters.'
            ]);
    }

    public function testCountryIn(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'country' => 'AA',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The selected country is invalid.'
            ]);
    }

    public function testEmailNullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'email' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('email');
    }

    public function testEmailString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'email' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a string.'
            ]);
    }

    public function testEmailEmail(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'email' => 'example.com',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    public function testEmailMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'email' => str_repeat('a', 244) . '@example.com',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.'
            ]);
    }

    public function testPhoneNullable(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'phone' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('phone');
    }

    public function testPhoneString(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'phone' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'phone' => 'The phone must be a string.'
            ]);
    }

    public function testPhoneMax(): void
    {
        $response = $this->postJson(route('addresses.store'), [
            'phone' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'phone' => 'The phone may not be greater than 255 characters.'
            ]);
    }

    public function testStored(): void
    {
        $faker = Factory::create();

        $data = [
            'name' => $faker->name,
            'street1' => $faker->buildingNumber . ' ' . $faker->streetName,
            'street2' => $faker->secondaryAddress,
            'locality' => $faker->city,
            'region' => $faker->state,
            'postal_code' => $faker->postcode,
            'country' => $faker->countryCode,
            'email' => $faker->email,
            'phone' => $faker->e164PhoneNumber,
        ];

        $response = $this->postJson(route('addresses.store'), $data);

        $address = Address::first();

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $address->id,
                    'name' => $data['name'],
                    'street1' => $data['street1'],
                    'street2' => $data['street2'],
                    'locality' => $data['locality'],
                    'region' => $data['region'],
                    'postal_code' => $data['postal_code'],
                    'country' => $data['country'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'created_at' => $address->created_at->toISOString(),
                    'updated_at' => $address->updated_at->toISOString(),
                ],
            ]);
    }
}
