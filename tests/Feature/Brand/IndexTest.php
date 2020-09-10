<?php

namespace Tests\Feature\Brand;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Brand;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(url('/shop-api/brands'), route('brands.index'));
    }

    public function testIndexed(): void
    {
        $brand = factory(Brand::class)->create();

        $response = $this->getJson(route('brands.index'));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
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
