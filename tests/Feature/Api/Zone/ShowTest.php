<?php

namespace Tests\Feature\Api\Zone;

use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/zones/' . $id),
            route('zones.show', $id)
        );
    }

    public function testNotFound()
    {
        $response = $this->getJson(route('zones.show', Str::uuid()));

        $response->assertNotFound();
    }

    public function testShown()
    {
        $zone = ZoneFactory::new()->create();

        $response = $this->getJson(route('zones.show', $zone));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $zone->id,
                    'name' => $zone->name,
                    'created_at' => $zone->created_at->toISOString(),
                    'updated_at' => $zone->updated_at->toISOString(),
                ],
            ]);
    }
}
