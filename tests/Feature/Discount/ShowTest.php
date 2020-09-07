<?php

namespace Tests\Feature\Api\v1\Discount;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Discount;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $code = Str::random(5);

        $this->assertSame(
            url('/shop-api/discounts/' . $code),
            route('discounts.show', $code)
        );
    }

    public function testNotFound()
    {
        $response = $this->getJson(route('discounts.show', Str::random(5)));

        $response->assertNotFound();
    }

    public function testNotFoundUnstarted()
    {
        $discount = factory(Discount::class)->create([
            'started_at' => Carbon::now()->addMinute(),
            'ended_at' => null
        ]);

        $response = $this->getJson(route('discounts.show', $discount->code));

        $response->assertNotFound();
    }

    public function testNotFoundEnded()
    {
        $discount = factory(Discount::class)->create([
            'started_at' => Carbon::now()->subHour(),
            'ended_at' => Carbon::now()->subMinute()
        ]);

        $response = $this->getJson(route('discounts.show', $discount->code));

        $response->assertNotFound();
    }

    public function testShown()
    {
        $discount = factory(Discount::class)->create([
            'started_at' => Carbon::now()->subMinute(),
            'ended_at' => Carbon::now()->addMinute()
        ]);

        $response = $this->getJson(route('discounts.show', $discount->code));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    'id' => $discount->id,
                    'name' => $discount->name,
                    'code' => $discount->code,
                    'percent' => $discount->percent,
                    'maximum' => $discount->maximum,
                    'limit' => $discount->limit,
                    'variant_id' => $discount->variant_id,
                    'started_at' => $discount->started_at->toISOString(),
                    'ended_at' => $discount->ended_at->toISOString(),
                    'created_at' => $discount->created_at->toISOString(),
                    'updated_at' => $discount->updated_at->toISOString(),
                ],
            ]);
    }
}
