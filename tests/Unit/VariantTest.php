<?php

namespace Tests\Unit;

use Database\Factories\BasketFactory;
use Database\Factories\DiscountFactory;
use Database\Factories\ImageFactory;
use Database\Factories\ProductFactory;
use Database\Factories\VariantFactory;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VariantTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $variant = VariantFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $variant->id);
        $this->assertFalse($variant->incrementing);
    }

    public function testSlugifies(): void
    {
        $variant = VariantFactory::new()
            ->create(['name' => 'Notebook (Hardcover, Plain)']);

        $this->assertSame('notebook-hardcover-plain', $variant->slug);

        $variant->update(['name' => 'Notebook (Hardcover, Blank)']);

        $this->assertSame('notebook-hardcover-blank', $variant->slug);
    }

    public function testBaskets(): void
    {
        $basket = BasketFactory::new()->create();

        $variant = VariantFactory::new()->create();
        $variant->baskets()->attach($basket, [
            'customizations' => [],
            'quantity' => 9,
            'price' => 2897,
        ]);

        $this->assertSame($basket->id, $variant->baskets[0]->id);
        $this->assertSame(9, $variant->baskets[0]->pivot->quantity);
        $this->assertSame(2897, $variant->baskets[0]->pivot->price);
    }

    public function testDiscounts(): void
    {
        $discount = DiscountFactory::new()->make();

        $variant = VariantFactory::new()->create();
        $variant->discounts()->save($discount);

        $this->assertSame($discount->id, $variant->discounts[0]->id);
    }

    public function testImages(): void
    {
        $image = ImageFactory::new()->create();

        $variant = VariantFactory::new()->create();
        $variant->images()->attach($image, ['position' => 1]);

        $this->assertSame($image->id, $variant->images[0]->id);
        $this->assertSame(1, $variant->images[0]->pivot->position);
    }

    public function testProduct(): void
    {
        $product = ProductFactory::new()->create();

        $variant = VariantFactory::new()->create();
        $variant->product()->associate($product);

        $this->assertSame($product->id, $variant->product->id);
    }

    public function testZones(): void
    {
        $zone = ZoneFactory::new()->create();

        $variant = VariantFactory::new()->create();
        $variant->zones()->attach($zone, ['delivery_cost' => 915]);

        $this->assertSame($zone->id, $variant->zones[0]->id);
        $this->assertSame(915, $variant->zones[0]->pivot->delivery_cost);
    }
}
