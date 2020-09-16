<?php

namespace Tests\Feature\Api\Address;

use Database\Factories\AddressFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/addresses/' . $id),
            route('shop-api.addresses.destroy', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->deleteJson(
            route('shop-api.addresses.destroy', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testDestroyed(): void
    {
        $address = AddressFactory::new()->create();

        $response = $this->deleteJson(
            route('shop-api.addresses.destroy', $address)
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $address->id,
                    'name' => $address->name,
                    'street1' => $address->street1,
                    'street2' => $address->street2,
                    'locality' => $address->locality,
                    'region' => $address->region,
                    'postal_code' => $address->postal_code,
                    'country' => $address->country,
                    'email' => $address->email,
                    'phone' => $address->phone,
                    'created_at' => $address->created_at->toISOString(),
                    'updated_at' => $address->updated_at->toISOString(),
                ],
            ]);

        $this->assertNull($address->fresh());
    }
}
