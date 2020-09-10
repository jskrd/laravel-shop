<?php

namespace Tests\Feature\Api\v1\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Product;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute()
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/products/' . $id),
            route('products.show', $id)
        );
    }

    public function testNotFound()
    {
        $response = $this->getJson(route('products.show', Str::uuid()));

        $response->assertNotFound();
    }

    public function testShown()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson(route('products.show', $product));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
