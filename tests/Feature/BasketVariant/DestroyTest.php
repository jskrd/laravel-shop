<?php

namespace Tests\Feature\BasketVariant;

use Database\Factories\BasketFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
        $variant = VariantFactory::new()->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [Str::uuid(), $variant])
        );

        $response->assertNotFound();
    }

    public function testVariantNotFound(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [$basket, Str::uuid()])
        );

        $response->assertNotFound();
    }

    public function testNotAttached(): void
    {
        $basket = BasketFactory::new()->create();
        $variant = VariantFactory::new()->create();

        $response = $this->deleteJson(
            route('baskets.variants.destroy', [$basket, $variant])
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }

    public function testDestroyed(): void
    {
        $variant = VariantFactory::new()->create(['price' => 2182]);

        $basket = BasketFactory::new()->create();
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
            ->assertJson([
                'data' => [],
            ]);
    }
}
