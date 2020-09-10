<?php

namespace Tests\Feature\VariantImage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Variant;
use Jskrd\Shop\Models\Image;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/variants/' . $id . '/images'),
            route('variants.images.index', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->getJson(route('variants.images.index', Str::uuid()));

        $response->assertNotFound();
    }

    public function testIndexed(): void
    {
        $variant = factory(Variant::class)->create();
        $variant->images()->attach(factory(Image::class)->create(), [
            'position' => 1,
        ]);

        $response = $this->getJson(route('variants.images.index', $variant));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'data' => [
                    [
                        'id' => $variant->images[0]->id,
                        'path' => $variant->images[0]->path,
                        'width' => $variant->images[0]->width,
                        'height' => $variant->images[0]->height,
                        'size' => $variant->images[0]->size,
                        'created_at' => $variant->images[0]->created_at->toISOString(),
                        'updated_at' => $variant->images[0]->updated_at->toISOString(),
                        'image_variant' => [
                            'image_id' => $variant->images[0]->pivot->image_id,
                            'variant_id' => $variant->images[0]->pivot->variant_id,
                            'position' => $variant->images[0]->pivot->position,
                            'created_at' => $variant->images[0]->pivot->created_at->toISOString(),
                            'updated_at' => $variant->images[0]->pivot->updated_at->toISOString(),
                        ],
                    ],
                ],
            ]);
    }
}
