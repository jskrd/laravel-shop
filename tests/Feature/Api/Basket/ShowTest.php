<?php

namespace Tests\Feature\Api\Basket;

use Database\Factories\BasketFactory;
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
            url('/shop-api/baskets/' . $id),
            route('shop-api.baskets.show', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(route('shop-api.baskets.show', Str::uuid()));

        $response->assertNotFound();
    }

    public function testShown(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->getJson(route('shop-api.baskets.show', $basket));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $basket->id,
                    'status' => $basket->status,
                    'variants_count' => $basket->variants_count,
                    'subtotal' => $basket->subtotal,
                    'discount_amount' => $basket->discount_amount,
                    'delivery_cost' => $basket->delivery_cost,
                    'total' => $basket->total,
                    'billing_address_id' => $basket->billing_address_id,
                    'delivery_address_id' => $basket->delivery_address_id,
                    'discount_id' => $basket->discount_id,
                    'created_at' => $basket->created_at->toISOString(),
                    'updated_at' => $basket->updated_at->toISOString(),
                ],
            ]);
    }
}
