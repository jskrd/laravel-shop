<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Database\Factories\BrandFactory;
use Database\Factories\ImageFactory;
use Database\Factories\ProductFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testEndable(): void
    {
        $unended = ProductFactory::new()->create(['ended_at' => null]);
        $ending = ProductFactory::new()->create(['ended_at' => Carbon::now()->addMinute()]);
        $ended = ProductFactory::new()->create(['ended_at' => Carbon::now()]);

        $this->assertFalse($unended->ended());
        $this->assertFalse($ending->ended());
        $this->assertTrue($ended->ended());

        $this->assertTrue(
            Product::get()->contains($unended) &&
            Product::get()->contains($ending) &&
            ! Product::get()->contains($ended)
        );

        $this->assertTrue(
            Product::withEnded()->get()->contains($unended) &&
            Product::withEnded()->get()->contains($ending) &&
            Product::withEnded()->get()->contains($ended)
        );

        $this->assertTrue(
            Product::withoutEnded()->get()->contains($unended) &&
            Product::withoutEnded()->get()->contains($ending) &&
            ! Product::withoutEnded()->get()->contains($ended)
        );

        $this->assertTrue(
            ! Product::onlyEnded()->get()->contains($unended) &&
            ! Product::onlyEnded()->get()->contains($ending) &&
            Product::onlyEnded()->get()->contains($ended)
        );
    }

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $product = ProductFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $product->id);
        $this->assertFalse($product->incrementing);
    }

    public function testSlugifies(): void
    {
        $product = ProductFactory::new()->create(['name' => 'Notebook']);

        $this->assertSame('notebook', $product->slug);

        $product->update(['name' => 'Photo book']);

        $this->assertSame('photo-book', $product->slug);
    }

    public function testStartable(): void
    {
        $unstarted = ProductFactory::new()->create(['started_at' => null]);
        $starting = ProductFactory::new()->create(['started_at' => Carbon::now()->addMinute()]);
        $started = ProductFactory::new()->create(['started_at' => Carbon::now()]);

        $this->assertFalse($unstarted->started());
        $this->assertFalse($starting->started());
        $this->assertTrue($started->started());

        $this->assertTrue(
            ! Product::get()->contains($unstarted) &&
            ! Product::get()->contains($starting) &&
            Product::get()->contains($started)
        );

        $this->assertTrue(
            Product::withUnstarted()->get()->contains($unstarted) &&
            Product::withUnstarted()->get()->contains($starting) &&
            Product::withUnstarted()->get()->contains($started)
        );

        $this->assertTrue(
            ! Product::withoutUnstarted()->get()->contains($unstarted) &&
            ! Product::withoutUnstarted()->get()->contains($starting) &&
            Product::withoutUnstarted()->get()->contains($started)
        );

        $this->assertTrue(
            Product::onlyUnstarted()->get()->contains($unstarted) &&
            Product::onlyUnstarted()->get()->contains($starting) &&
            ! Product::onlyUnstarted()->get()->contains($started)
        );
    }

    public function testBrand(): void
    {
        $brand = BrandFactory::new()->create();

        $product = ProductFactory::new()->create();
        $product->brand()->associate($brand);

        $this->assertSame($brand->id, $product->brand->id);
    }

    public function testImages(): void
    {
        $image = ImageFactory::new()->create();

        $product = ProductFactory::new()->create();
        $product->images()->attach($image, ['position' => 9]);

        $this->assertSame($image->id, $product->images[0]->id);
        $this->assertSame(9, $product->images[0]->pivot->position);
    }

    public function testVariants(): void
    {
        $variant = VariantFactory::new()->make();

        $product = ProductFactory::new()->create();
        $product->variants()->save($variant);

        $this->assertSame($variant->id, $product->variants[0]->id);
    }
}
