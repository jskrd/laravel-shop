<?php

namespace Tests\Unit;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $brand = BrandFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $brand->id);
        $this->assertFalse($brand->incrementing);
    }

    public function testSlugifies(): void
    {
        $brand = BrandFactory::new()->create(['name' => 'Champlin Inc']);

        $this->assertSame('champlin-inc', $brand->slug);

        $brand->update(['name' => 'Smith-Leffler']);

        $this->assertSame('smith-leffler', $brand->slug);
    }

    public function testProducts(): void
    {
        $product = ProductFactory::new()->make();

        $brand = BrandFactory::new()->create();
        $brand->products()->save($product);

        $this->assertSame($product->id, $brand->products[0]->id);
    }
}
