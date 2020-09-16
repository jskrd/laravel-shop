<?php

namespace Tests\Feature\Api\Country;

use Database\Factories\CountryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/countries/' . $id),
            route('shop-api.countries.show', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(
            route('shop-api.countries.show', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testShown(): void
    {
        $country = CountryFactory::new()->create();

        $response = $this->getJson(route('shop-api.countries.show', $country));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $country->id,
                    'alpha2' => $country->alpha2,
                    'zone_id' => $country->zone_id,
                    'created_at' => $country->created_at->toISOString(),
                    'updated_at' => $country->updated_at->toISOString(),
                ],
            ]);
    }
}
