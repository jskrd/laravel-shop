<?php

namespace Tests\Feature\Variant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Variant;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $this->assertSame(url('/shop-api/variants'), route('variants.index'));
    }

    public function testIndexed()
    {
        $variant = factory(Variant::class)->create();

        $response = $this->getJson(route('variants.index'));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    [
                        'id' => $variant->id,
                        'name' => $variant->name,
                        'slug' => $variant->slug,
                        'price' => $variant->price,
                        'original_price' => $variant->original_price,
                        'delivery_cost' => $variant->delivery_cost,
                        'sku' => $variant->sku,
                        'stock' => $variant->stock,
                        'option1' => $variant->option1,
                        'option2' => $variant->option2,
                        'option3' => $variant->option3,
                        'product_id' => $variant->product_id,
                        'created_at' => $variant->created_at->toISOString(),
                        'updated_at' => $variant->updated_at->toISOString(),
                    ],
                ],
                'links' => [
                    'first' => route('variants.index', ['page' => 1]),
                    'last' => route('variants.index', ['page' => 1]),
                    'next' => null,
                    'prev' => null,
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => route('variants.index'),
                    'per_page' => 24,
                    'to' => 1,
                    'total' => 1,
                ],
            ]);
    }
}