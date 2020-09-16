<?php

namespace Tests\Feature\Api\Product;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $this->assertSame(
            url('/shop-api/products'),
            route('shop-api.products.index')
        );
    }

    public function testIndexed()
    {
        $product = ProductFactory::new()->create();

        $response = $this->getJson(route('shop-api.products.index'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'options1' => $product->options1,
                        'options2' => $product->options2,
                        'options3' => $product->options3,
                        'created_at' => $product->created_at->toISOString(),
                        'updated_at' => $product->updated_at->toISOString(),
                    ],
                ],
                'links' => [
                    'first' => route('shop-api.products.index', ['page' => 1]),
                    'last' => route('shop-api.products.index', ['page' => 1]),
                    'next' => null,
                    'prev' => null,
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => route('shop-api.products.index'),
                    'links' => [
                        [
                            'active' => false,
                            'label' => 'Previous',
                            'url' => null,
                        ],
                        [
                            'active' => true,
                            'label' => 1,
                            'url' => route('shop-api.products.index', ['page' => 1]),
                        ],
                        [
                            'active' => false,
                            'label' => 'Next',
                            'url' => null,
                        ],
                    ],
                    'per_page' => 24,
                    'to' => 1,
                    'total' => 1,
                ],
            ]);
    }
}
