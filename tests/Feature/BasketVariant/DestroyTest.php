<?php

namespace Tests\Feature\BasketVariant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Variant;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $basketId = Str::uuid();
        $variantId = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $basketId . '/variants/' . $variantId),
            route('baskets.variants.destroy', [$basketId, $variantId])
        );
    }

    public function testBasketNotFound(): void
    {
        $variant = factory(Variant::class)->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [Str::uuid(), $variant])
        );

        $response->assertNotFound();
    }

    public function testVariantNotFound(): void
    {
        $basket = factory(Basket::class)->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [$basket, Str::uuid()])
        );

        $response->assertNotFound();
    }

    public function testNotAttached(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [$basket, $variant])
        );

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [],
            ]);
    }

    public function testDestroyed(): void
    {
        $variant = factory(Variant::class)->create(['price' => 2182]);

        $basket = factory(Basket::class)->create();
        $basket->variants()->attach($variant, [
            'customizations' => '{}',
            'quantity' => 0,
            'price' => 0,
        ]);

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [$basket, $variant])
        );

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [],
            ]);
    }
}
