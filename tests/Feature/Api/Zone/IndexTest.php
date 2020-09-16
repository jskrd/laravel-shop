<?php

namespace Tests\Feature\Api\Zone;

use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $this->assertSame(
            url('/shop-api/zones'),
            route('shop-api.zones.index')
        );
    }

    public function testIndexed()
    {
        $zone = ZoneFactory::new()->create();

        $response = $this->getJson(route('shop-api.zones.index'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $zone->id,
                        'name' => $zone->name,
                        'created_at' => $zone->created_at->toISOString(),
                        'updated_at' => $zone->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
