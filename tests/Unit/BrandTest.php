<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Brand;
use Jskrd\Shop\Models\Product;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $brand = factory(Brand::class)->create();

        $this->assertRegExp($uuidPattern, $brand->id);
        $this->assertFalse($brand->incrementing);
    }

    public function testSlugifies(): void
    {
        $brand = factory(Brand::class)->create(['name' => 'Champlin Inc']);

        $this->assertSame('champlin-inc', $brand->slug);

        $brand->update(['name' => 'Smith-Leffler']);

        $this->assertSame('smith-leffler', $brand->slug);
    }

    public function testProducts(): void
    {
        $product = factory(Product::class)->make();

        $brand = factory(Brand::class)->create();
        $brand->products()->save($product);

        $this->assertSame($product->id, $brand->products[0]->id);
    }
}
