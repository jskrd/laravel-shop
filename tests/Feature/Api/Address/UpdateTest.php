<?php

namespace Tests\Feature\Api\Address;

use Database\Factories\AddressFactory;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/addresses/' . $id),
            route('shop-api.addresses.update', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->putJson(
            route('shop-api.addresses.update', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testNameRequired(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'name' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.'
            ]);
    }

    public function testNameString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'name' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name must be a string.'
            ]);
    }

    public function testNameMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'name' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name may not be greater than 255 characters.'
            ]);
    }

    public function testStreet1Required(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street1' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 field is required.'
            ]);
    }

    public function testStreet1String(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street1' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 must be a string.'
            ]);
    }

    public function testStreet1Max(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street1' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street1' => 'The street1 may not be greater than 255 characters.'
            ]);
    }

    public function testStreet2Nullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street2' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('street2');
    }

    public function testStreet2String(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street2' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street2' => 'The street2 must be a string.'
            ]);
    }

    public function testStreet2Max(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'street2' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'street2' => 'The street2 may not be greater than 255 characters.'
            ]);
    }

    public function testLocalityNullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'locality' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('locality');
    }

    public function testLocalityString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'locality' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'locality' => 'The locality must be a string.'
            ]);
    }

    public function testLocalityMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'locality' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'locality' => 'The locality may not be greater than 255 characters.'
            ]);
    }

    public function testRegionNullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'region' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('region');
    }

    public function testRegionString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'region' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'region' => 'The region must be a string.'
            ]);
    }

    public function testRegionMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'region' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'region' => 'The region may not be greater than 255 characters.'
            ]);
    }

    public function testPostalCodeNullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'postal_code' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('postal_code');
    }

    public function testPostalCodeString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'postal_code' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'postal_code' => 'The postal code must be a string.'
            ]);
    }

    public function testPostalCodeMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'postal_code' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'postal_code' => 'The postal code may not be greater than 255 characters.'
            ]);
    }

    public function testCountryRequired(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'country' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country field is required.'
            ]);
    }

    public function testCountryString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'country' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country must be 2 characters.'
            ]);
    }

    public function testCountrySize(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'country' => 'GBR',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The country must be 2 characters.'
            ]);
    }

    public function testCountryIn(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'country' => 'AA',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'country' => 'The selected country is invalid.'
            ]);
    }

    public function testEmailNullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'email' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('email');
    }

    public function testEmailString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'email' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a string.'
            ]);
    }

    public function testEmailEmail(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'email' => 'example.com',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }

    public function testEmailMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'email' => str_repeat('a', 244) . '@example.com',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.'
            ]);
    }

    public function testPhoneNullable(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'phone' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('phone');
    }

    public function testPhoneString(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'phone' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'phone' => 'The phone must be a string.'
            ]);
    }

    public function testPhoneMax(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            [
                'phone' => str_repeat('a', 256),
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'phone' => 'The phone may not be greater than 255 characters.'
            ]);
    }

    public function testUpdated(): void
    {
        $address = AddressFactory::new()->create();

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

        $response = $this->putJson(
            route('shop-api.addresses.update', $address),
            $data
        );

        $address->refresh();

        $response
            ->assertStatus(200)
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
