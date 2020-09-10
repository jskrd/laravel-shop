<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Image;
use Jskrd\Shop\Models\Product;
use Jskrd\Shop\Models\Variant;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $image = factory(Image::class)->create();

        $this->assertRegExp($uuidPattern, $image->id);
        $this->assertFalse($image->incrementing);
    }

    public function testProducts(): void
    {
        $product = factory(Product::class)->create();

        $image = factory(Image::class)->create();
        $image->products()->attach($product, ['position' => 8]);

        $this->assertSame($product->id, $image->products[0]->id);
        $this->assertSame(8, $image->products[0]->pivot->position);
    }

    public function testVariants(): void
    {
        $variant = factory(Variant::class)->create();

        $image = factory(Image::class)->create();
        $image->variants()->attach($variant, ['position' => 2]);

        $this->assertSame($variant->id, $image->variants[0]->id);
        $this->assertSame(2, $image->variants[0]->pivot->position);
    }
}
