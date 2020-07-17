<?php

namespace Tests\Feature\BasketVariant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Basket;
use Jskrd\Shop\Variant;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $basketId = Str::uuid();
        $variantId = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $basketId . '/variants/' . $variantId),
            route('baskets.variants.show', [$basketId, $variantId])
        );
    }

    public function testBasketNotFound(): void
    {
        $variant = factory(Variant::class)->create();

        $response = $this->getJson(
            route('baskets.variants.show', [Str::uuid(), $variant])
        );

        $response->assertNotFound();
    }

    public function testVariantNotFound(): void
    {
        $basket = factory(Basket::class)->create();

        $response = $this->getJson(
            route('baskets.variants.show', [$basket, Str::uuid()])
        );

        $response->assertNotFound();
    }

    public function testShown(): void
    {
        $variant = factory(Variant::class)->create(['price' => 2182]);

        $basket = factory(Basket::class)->create();
        $basket->variants()->attach($variant, [
            'customizations' => '{"name": "Alice"}',
            'quantity' => rand(1, 10),
            'price' => rand(100, 10000),
        ]);

        $response = $this->getJson(
            route('baskets.variants.show', [$basket, $variant])
        );

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    'id' => $basket->variants[0]->id,
                    'name' => $basket->variants[0]->name,
                    'slug' => $basket->variants[0]->slug,
                    'price' => $basket->variants[0]->price,
                    'delivery_cost' => $basket->variants[0]->delivery_cost,
                    'stock' => $basket->variants[0]->stock,
                    'option1' => $basket->variants[0]->option1,
                    'option2' => $basket->variants[0]->option2,
                    'option3' => $basket->variants[0]->option3,
                    'product_id' => $basket->variants[0]->product_id,
                    'created_at' => $basket->variants[0]->created_at->toIso8601String(),
                    'updated_at' => $basket->variants[0]->updated_at->toIso8601String(),
                    'basket_variant' => [
                        'basket_id' => $basket->variants[0]->pivot->basket_id,
                        'variant_id' => $basket->variants[0]->pivot->variant_id,
                        'customizations' => $basket->variants[0]->pivot->customizations,
                        'quantity' => $basket->variants[0]->pivot->quantity,
                        'price' => $basket->variants[0]->pivot->price,
                        'delivery_cost' => $basket->variants[0]->pivot->delivery_cost,
                        'created_at' => $basket->variants[0]->pivot->created_at->toIso8601String(),
                        'updated_at' => $basket->variants[0]->pivot->updated_at->toIso8601String(),
                    ],
                ],
            ]);
    }
}
