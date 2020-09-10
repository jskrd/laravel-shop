<?php

namespace Tests\Feature\Api\v1\Zone;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Zone;
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
        $zone = factory(Zone::class)->create();

        $response = $this->getJson(route('zones.show', $zone));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    'id' => $zone->id,
                    'name' => $zone->name,
                    'created_at' => $zone->created_at->toISOString(),
                    'updated_at' => $zone->updated_at->toISOString(),
                ],
            ]);
    }
}
