<?php

namespace Tests\Feature\Discount;

use Database\Factories\DiscountFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(url('/shop-api/discounts'), route('discounts.index'));
    }

    public function testCodeRequired(): void
    {
        $response = $this->getJson(route('discounts.index', ['code' => '']));

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'code' => 'The code field is required.'
            ]);
    }

    public function testCodeExists(): void
    {
        $response = $this->getJson(
            route('discounts.index', ['code' => Str::random(5)])
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'code' => 'The selected code is invalid.'
            ]);
    }

    public function testIndexed(): void
    {
        $discounts = DiscountFactory::new()->count(3)->create();

        $response = $this->getJson(
            route('discounts.index', ['code' => $discounts[1]->code])
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $discounts[1]->id,
                        'name' => $discounts[1]->name,
                        'code' => $discounts[1]->code,
                        'percent' => $discounts[1]->percent,
                        'maximum' => $discounts[1]->maximum,
                        'limit' => $discounts[1]->limit,
                        'variant_id' => $discounts[1]->variant_id,
                        'started_at' => $discounts[1]->started_at->toISOString(),
                        'ended_at' => $discounts[1]->ended_at->toISOString(),
                        'created_at' => $discounts[1]->created_at->toISOString(),
                        'updated_at' => $discounts[1]->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
