<?php

namespace Tests\Feature\Api\Country;

use Database\Factories\CountryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(
            url('/shop-api/countries'),
            route('shop-api.countries.index')
        );
    }

    public function testIndexed(): void
    {
        $country = CountryFactory::new()->create();

        $response = $this->getJson(route('shop-api.countries.index'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $country->id,
                        'alpha2' => $country->alpha2,
                        'zone_id' => $country->zone_id,
                        'created_at' => $country->created_at->toISOString(),
                        'updated_at' => $country->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
