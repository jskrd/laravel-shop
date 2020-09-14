<?php

namespace Tests\Feature\BasketVariant;

use Database\Factories\BasketFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $id . '/variants'),
            route('baskets.variants.index', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(
            route('baskets.variants.index', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testIndexed(): void
    {
        $basket = BasketFactory::new()->create();
        $basket->variants()->attach(VariantFactory::new()->create(), [
            'customizations' => ['name' => 'Alice'],
            'quantity' => 4,
            'price' => 2563,
        ]);

        $response = $this->getJson(route('baskets.variants.index', $basket));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    [
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
                ],
            ]);
    }
}
