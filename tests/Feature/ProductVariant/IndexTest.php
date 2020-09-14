<?php

namespace Tests\Feature\ProductVariant;

use Database\Factories\ProductFactory;
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
            url('/shop-api/products/' . $id . '/variants'),
            route('products.variants.index', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(
            route('products.variants.index', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testIndexed(): void
    {
        $product = ProductFactory::new()->create();

        $variant = VariantFactory::new()->make();
        $variant->product()->associate($product);
        $variant->save();

        $response = $this->getJson(route('products.variants.index', $product));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $product->variants[0]->id,
                        'name' => $product->variants[0]->name,
                        'slug' => $product->variants[0]->slug,
                        'price' => $product->variants[0]->price,
                        'original_price' => $product->variants[0]->original_price,
                        'delivery_cost' => $product->variants[0]->delivery_cost,
                        'sku' => $product->variants[0]->sku,
                        'stock' => $product->variants[0]->stock,
                        'option1' => $product->variants[0]->option1,
                        'option2' => $product->variants[0]->option2,
                        'option3' => $product->variants[0]->option3,
                        'product_id' => $product->variants[0]->product_id,
                        'created_at' => $product->variants[0]->created_at->toISOString(),
                        'updated_at' => $product->variants[0]->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
