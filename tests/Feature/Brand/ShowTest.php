<?php

namespace Tests\Feature\Api\v1\Brand;

use Database\Factories\BrandFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/brands/' . $id),
            route('brands.show', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(route('brands.show', Str::uuid()));

        $response->assertNotFound();
    }

    public function testShown(): void
    {
        $brand = BrandFactory::new()->create();

        $response = $this->getJson(route('brands.show', $brand));

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'created_at' => $brand->created_at->toISOString(),
                    'updated_at' => $brand->updated_at->toISOString(),
                ],
            ]);
    }
}
