<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Discount;
use Jskrd\Shop\Models\Image;
use Jskrd\Shop\Models\Product;
use Jskrd\Shop\Models\Variant;
use Jskrd\Shop\Models\Zone;
use Tests\TestCase;

class VariantTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $variant = factory(Variant::class)->create();

        $this->assertRegExp($uuidPattern, $variant->id);
        $this->assertFalse($variant->incrementing);
    }

    public function testSlugifies(): void
    {
        $variant = factory(Variant::class)
            ->create(['name' => 'Notebook (Hardcover, Plain)']);

        $this->assertSame('notebook-hardcover-plain', $variant->slug);

        $variant->update(['name' => 'Notebook (Hardcover, Blank)']);

        $this->assertSame('notebook-hardcover-blank', $variant->slug);
    }

    public function testBaskets(): void
    {
        $basket = factory(Basket::class)->create();

        $variant = factory(Variant::class)->create();
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
        $discount = factory(Discount::class)->make();

        $variant = factory(Variant::class)->create();
        $variant->discounts()->save($discount);

        $this->assertSame($discount->id, $variant->discounts[0]->id);
    }

    public function testImages(): void
    {
        $image = factory(Image::class)->create();

        $variant = factory(Variant::class)->create();
        $variant->images()->attach($image, ['position' => 1]);

        $this->assertSame($image->id, $variant->images[0]->id);
        $this->assertSame(1, $variant->images[0]->pivot->position);
    }

    public function testProduct(): void
    {
        $product = factory(Product::class)->create();

        $variant = factory(Variant::class)->create();
        $variant->product()->associate($product);

        $this->assertSame($product->id, $variant->product->id);
    }

    public function testZones(): void
    {
        $zone = factory(Zone::class)->create();

        $variant = factory(Variant::class)->create();
        $variant->zones()->attach($zone, ['delivery_cost' => 915]);

        $this->assertSame($zone->id, $variant->zones[0]->id);
        $this->assertSame(915, $variant->zones[0]->pivot->delivery_cost);
    }
}
