<?php

namespace Tests\Feature\Country;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Country;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(url('/shop-api/countries'), route('countries.index'));
    }

    public function testIndexed(): void
    {
        $country = factory(Country::class)->create();

        $response = $this->getJson(route('countries.index'));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
