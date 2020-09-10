<?php

namespace Tests\Feature\BasketVariant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Variant;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $basketId = Str::uuid();
        $variantId = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $basketId . '/variants/' . $variantId),
            route('baskets.variants.update', [$basketId, $variantId])
        );
    }

    public function testBasketNotFound(): void
    {
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [Str::uuid(), $variant])
        );

        $response->assertNotFound();
    }

    public function testVariantNotFound(): void
    {
        $basket = factory(Basket::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, Str::uuid()])
        );

        $response->assertNotFound();
    }

    public function testCustomizationsRequired(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'customizations' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations field is required.'
            ]);
    }

    public function testCustomizationsString(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'customizations' => 123,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations must be a string.'
            ]);
    }

    public function testCustomizationsJson(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'customizations' => 'name = Alice',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations must be a valid JSON string.'
            ]);
    }

    public function testQuantityRequired(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'quantity' => '',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity field is required.'
            ]);
    }

    public function testQuantityInteger(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'quantity' => 'one',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity must be an integer.'
            ]);
    }

    public function testQuantityBetween(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'quantity' => 4294967296,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity must be between 1 and 4294967295.'
            ]);
    }

    public function testNotAttached(): void
    {
        $basket = factory(Basket::class)->create();
        $variant = factory(Variant::class)->create();

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'customizations' => '{"name": "Bob"}',
                'quantity' => 5,
            ]
        );

        $response->assertNotFound();
    }

    public function testUpdated(): void
    {
        $variant = factory(Variant::class)->create(['price' => 2182]);

        $basket = factory(Basket::class)->create();
        $basket->variants()->attach($variant, [
            'customizations' => '{"name": "Alice"}',
            'quantity' => 9,
            'price' => 7298,
        ]);

        $response = $this->putJson(
            route('baskets.variants.update', [$basket, $variant]),
            [
                'customizations' => '{"name": "Bob"}',
                'quantity' => 5,
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
                        'variant_id' => $variant->id,
                        'customizations' => '{"name": "Bob"}',
                        'quantity' => 5,
                        'price' => 7298,
                        'created_at' => $basket->variants[0]->pivot->created_at->toISOString(),
                        'updated_at' => $basket->variants[0]->pivot->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
