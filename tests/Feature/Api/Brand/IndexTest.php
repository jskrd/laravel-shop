<?php

namespace Tests\Feature\Api\Brand;

use Database\Factories\BrandFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(
            url('/shop-api/brands'),
            route('shop-api.brands.index')
        );
    }

    public function testIndexed(): void
    {
        $brand = BrandFactory::new()->create();

        $response = $this->getJson(route('shop-api.brands.index'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'slug' => $brand->slug,
                        'created_at' => $brand->created_at->toISOString(),
                        'updated_at' => $brand->updated_at->toISOString(),
                    ],
                ],
            ]);
    }
}
