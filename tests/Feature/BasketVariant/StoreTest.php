<?php

namespace Tests\Feature\BasketVariant;

use Database\Factories\BasketFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $id . '/variants'),
            route('baskets.variants.store', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->postJson(
            route('baskets.variants.store', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testVariantIdRequired(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'variant_id' => 'The variant id field is required.'
            ]);
    }

    public function testVariantIdString(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => 12,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'variant_id' => 'The variant id must be a string.'
            ]);
    }

    public function testVariantIdUuid(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => '12',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'variant_id' => 'The variant id must be a valid UUID.'
            ]);
    }

    public function testVariantIdExists(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => Str::uuid(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'variant_id' => 'The selected variant id is invalid.'
            ]);
    }

    public function testCustomizationsRequired(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'customizations' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations field is required.'
            ]);
    }

    public function testCustomizationsString(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'customizations' => 123,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations must be a string.'
            ]);
    }

    public function testCustomizationsJson(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'customizations' => 'name = Alice',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customizations' => 'The customizations must be a valid JSON string.'
            ]);
    }

    public function testQuantityRequired(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'quantity' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity field is required.'
            ]);
    }

    public function testQuantityInteger(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'quantity' => 'one',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity must be an integer.'
            ]);
    }

    public function testQuantityBetween(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'quantity' => 4294967296,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'quantity' => 'The quantity must be between 1 and 4294967295.'
            ]);
    }

    public function testVariantAlreadyAttached(): void
    {
        $variant = VariantFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->variants()->attach($variant, [
            'customizations' => '{}',
            'quantity' => 1,
            'price' => 0,
        ]);

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => $variant->id,
            'customizations' => '{}',
            'quantity' => 1,
        ]);

        $response->assertStatus(409);
    }

    public function testStored(): void
    {
        $basket = BasketFactory::new()->create();

        $variant = VariantFactory::new()->create(['price' => 7298]);

        $response = $this->postJson(route('baskets.variants.store', $basket), [
            'variant_id' => $variant->id,
            'customizations' => '{"name": "Alice"}',
            'quantity' => 2,
        ]);

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
                        'variant_id' => $variant->id,
                        'customizations' => '{"name": "Alice"}',
                        'quantity' => 2,
                        'price' => $variant->price,
                        'created_at' => $basket->variants[0]->pivot->created_at->toISOString(),
                        'updated_at' => $basket->variants[0]->pivot->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
