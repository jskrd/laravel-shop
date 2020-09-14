<?php

namespace Tests\Feature\Product;

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
            route('products.index')
        );
    }

    public function testIndexed()
    {
        $product = ProductFactory::new()->create();

        $response = $this->getJson(route('products.index'));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
                    'first' => route('products.index', ['page' => 1]),
                    'last' => route('products.index', ['page' => 1]),
                    'next' => null,
                    'prev' => null,
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => route('products.index'),
                    'links' => [
                        [
                            'active' => false,
                            'label' => 'Next',
                            'url' => null,
                        ],
                        [
                            'active' => false,
                            'label' => 'Previous',
                            'url' => null,
                        ],
                        [
                            'active' => true,
                            'label' => 1,
                            'url' => route('products.index', ['page' => 1]),
                        ]
                    ],
                    'per_page' => 24,
                    'to' => 1,
                    'total' => 1,
                ],
            ]);
    }
}
