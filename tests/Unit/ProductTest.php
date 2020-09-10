<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Brand;
use Jskrd\Shop\Models\Image;
use Jskrd\Shop\Models\Product;
use Jskrd\Shop\Models\Variant;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testEndable(): void
    {
        $unended = factory(Product::class)->create(['ended_at' => null]);
        $ending = factory(Product::class)->create(['ended_at' => Carbon::now()->addMinute()]);
        $ended = factory(Product::class)->create(['ended_at' => Carbon::now()]);

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

        $product = factory(Product::class)->create();

        $this->assertRegExp($uuidPattern, $product->id);
        $this->assertFalse($product->incrementing);
    }

    public function testSlugifies(): void
    {
        $product = factory(Product::class)->create(['name' => 'Notebook']);

        $this->assertSame('notebook', $product->slug);

        $product->update(['name' => 'Photo book']);

        $this->assertSame('photo-book', $product->slug);
    }

    public function testStartable(): void
    {
        $unstarted = factory(Product::class)->create(['started_at' => null]);
        $starting = factory(Product::class)->create(['started_at' => Carbon::now()->addMinute()]);
        $started = factory(Product::class)->create(['started_at' => Carbon::now()]);

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
        $brand = factory(Brand::class)->create();

        $product = factory(Product::class)->create();
        $product->brand()->associate($brand);

        $this->assertSame($brand->id, $product->brand->id);
    }

    public function testImages(): void
    {
        $image = factory(Image::class)->create();

        $product = factory(Product::class)->create();
        $product->images()->attach($image, ['position' => 9]);

        $this->assertSame($image->id, $product->images[0]->id);
        $this->assertSame(9, $product->images[0]->pivot->position);
    }

    public function testVariants(): void
    {
        $variant = factory(Variant::class)->make();

        $product = factory(Product::class)->create();
        $product->variants()->save($variant);

        $this->assertSame($variant->id, $product->variants[0]->id);
    }
}
