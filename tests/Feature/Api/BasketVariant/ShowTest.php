<?php

namespace Tests\Feature\Api\BasketVariant;

use Database\Factories\BasketFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
        $variant = VariantFactory::new()->create();

        $response = $this->getJson(
            route('baskets.variants.show', [Str::uuid(), $variant])
        );

        $response->assertNotFound();
    }

    public function testVariantNotFound(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->getJson(
            route('baskets.variants.show', [$basket, Str::uuid()])
        );

        $response->assertNotFound();
    }

    public function testShown(): void
    {
        $variant = VariantFactory::new()->create(['price' => 2182]);

        $basket = BasketFactory::new()->create();
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
            ->assertJson([
                'data' => [
                    'id' => $basket->variants[0]->id,
                    'name' => $basket->variants[0]->name,
                    'slug' => $basket->variants[0]->slug,
                    'price' => $basket->variants[0]->price,
                    'original_price' => $basket->variants[0]->original_price,
                    'delivery_cost' => $basket->variants[0]->delivery_cost,
                    'sku' => $basket->variants[0]->sku,
                    'stock' => $basket->variants[0]->stock,
                    'option1' => $basket->variants[0]->option1,
                    'option2' => $basket->variants[0]->option2,
                    'option3' => $basket->variants[0]->option3,
                    'product_id' => $basket->variants[0]->product_id,
                    'created_at' => $basket->variants[0]->created_at->toISOString(),
                    'updated_at' => $basket->variants[0]->updated_at->toISOString(),
                    'basket_variant' => [
                        'basket_id' => $basket->variants[0]->pivot->basket_id,
                        'variant_id' => $basket->variants[0]->pivot->variant_id,
                        'customizations' => $basket->variants[0]->pivot->customizations,
                        'quantity' => $basket->variants[0]->pivot->quantity,
                        'price' => $basket->variants[0]->pivot->price,
                        'created_at' => $basket->variants[0]->pivot->created_at->toISOString(),
                        'updated_at' => $basket->variants[0]->pivot->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
