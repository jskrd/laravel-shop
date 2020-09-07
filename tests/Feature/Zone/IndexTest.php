<?php

namespace Tests\Feature\Zone;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Zone;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $this->assertSame(
            url('/shop-api/zones'),
            route('zones.index')
        );
    }

    public function testIndexed()
    {
        $zone = factory(Zone::class)->create();

        $response = $this->getJson(route('zones.index'));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
