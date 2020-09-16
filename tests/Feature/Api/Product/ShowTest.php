<?php

namespace Tests\Feature\Api\Product;

use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/products/' . $id),
            route('shop-api.products.show', $id)
        );
    }

    public function testNotFound()
    {
        $response = $this->getJson(
            route('shop-api.products.show', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testShown()
    {
        $product = ProductFactory::new()->create();

        $response = $this->getJson(route('shop-api.products.show', $product));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'options1' => $product->options1,
                    'options2' => $product->options2,
                    'options3' => $product->options3,
                    'created_at' => $product->created_at->toISOString(),
                    'updated_at' => $product->updated_at->toISOString(),
                ],
            ]);
    }
}
