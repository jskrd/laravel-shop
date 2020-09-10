<?php

namespace Tests\Feature\ProductImage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Product;
use Jskrd\Shop\Models\Image;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/products/' . $id . '/images'),
            route('products.images.index', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(route('products.images.index', Str::uuid()));

        $response->assertNotFound();
    }

    public function testIndexed(): void
    {
        $product = factory(Product::class)->create();
        $product->images()->attach(factory(Image::class)->create(), [
            'position' => 1,
        ]);

        $response = $this->getJson(route('products.images.index', $product));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    [
                        'id' => $product->images[0]->id,
                        'path' => $product->images[0]->path,
                        'width' => $product->images[0]->width,
                        'height' => $product->images[0]->height,
                        'size' => $product->images[0]->size,
                        'created_at' => $product->images[0]->created_at->toISOString(),
                        'updated_at' => $product->images[0]->updated_at->toISOString(),
                        'image_product' => [
                            'image_id' => $product->images[0]->pivot->image_id,
                            'product_id' => $product->images[0]->pivot->product_id,
                            'position' => $product->images[0]->pivot->position,
                            'created_at' => $product->images[0]->pivot->created_at->toISOString(),
                            'updated_at' => $product->images[0]->pivot->updated_at->toISOString(),
                        ],
                    ],
                ],
            ]);
    }
}
