<?php

namespace Tests\Feature\Address;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Address;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/addresses/' . $id),
            route('addresses.destroy', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->deleteJson(route('addresses.destroy', Str::uuid()));

        $response->assertNotFound();
    }

    public function testDestroyed(): void
    {
        $address = factory(Address::class)->create();

        $response = $this->deleteJson(route('addresses.destroy', $address));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
