<?php

namespace Tests\Feature\Api\v1\Variant;

use Database\Factories\VariantFactory;
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
            url('/shop-api/variants/' . $id),
            route('variants.show', $id)
        );
    }

    public function testNotFound()
    {
        $response = $this->getJson(route('variants.show', Str::uuid()));

        $response->assertNotFound();
    }

    public function testShown()
    {
        $variant = VariantFactory::new()->create();

        $response = $this->getJson(route('variants.show', $variant));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
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
            ]);
    }
}
