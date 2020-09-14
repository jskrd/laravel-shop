<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Database\Factories\BasketFactory;
use Database\Factories\DiscountFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Discount;
use Tests\TestCase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $discount = DiscountFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $discount->id);
        $this->assertFalse($discount->incrementing);
    }

    public function testStartable(): void
    {
        $unstarted = DiscountFactory::new()->create(['started_at' => null]);
        $starting = DiscountFactory::new()->create(['started_at' => Carbon::now()->addMinute()]);
        $started = DiscountFactory::new()->create(['started_at' => Carbon::now()]);

        $this->assertFalse($unstarted->started());
        $this->assertFalse($starting->started());
        $this->assertTrue($started->started());

        $this->assertTrue(
            ! Discount::get()->contains($unstarted) &&
            ! Discount::get()->contains($starting) &&
            Discount::get()->contains($started)
        );

        $this->assertTrue(
            Discount::withUnstarted()->get()->contains($unstarted) &&
            Discount::withUnstarted()->get()->contains($starting) &&
            Discount::withUnstarted()->get()->contains($started)
        );

        $this->assertTrue(
            ! Discount::withoutUnstarted()->get()->contains($unstarted) &&
            ! Discount::withoutUnstarted()->get()->contains($starting) &&
            Discount::withoutUnstarted()->get()->contains($started)
        );

        $this->assertTrue(
            Discount::onlyUnstarted()->get()->contains($unstarted) &&
            Discount::onlyUnstarted()->get()->contains($starting) &&
            ! Discount::onlyUnstarted()->get()->contains($started)
        );
    }

    public function testEndable(): void
    {
        $unended = DiscountFactory::new()->create(['ended_at' => null]);
        $ending = DiscountFactory::new()->create(['ended_at' => Carbon::now()->addMinute()]);
        $ended = DiscountFactory::new()->create(['ended_at' => Carbon::now()]);

        $this->assertFalse($unended->ended());
        $this->assertFalse($ending->ended());
        $this->assertTrue($ended->ended());

        $this->assertTrue(
            Discount::get()->contains($unended) &&
            Discount::get()->contains($ending) &&
            ! Discount::get()->contains($ended)
        );

        $this->assertTrue(
            Discount::withEnded()->get()->contains($unended) &&
            Discount::withEnded()->get()->contains($ending) &&
            Discount::withEnded()->get()->contains($ended)
        );

        $this->assertTrue(
            Discount::withoutEnded()->get()->contains($unended) &&
            Discount::withoutEnded()->get()->contains($ending) &&
            ! Discount::withoutEnded()->get()->contains($ended)
        );

        $this->assertTrue(
            ! Discount::onlyEnded()->get()->contains($unended) &&
            ! Discount::onlyEnded()->get()->contains($ending) &&
            Discount::onlyEnded()->get()->contains($ended)
        );
    }

    public function testBaskets(): void
    {
        $basket = BasketFactory::new()->make();

        $discount = DiscountFactory::new()->create();
        $discount->baskets()->save($basket);

        $this->assertSame($basket->id, $discount->baskets[0]->id);
    }

    public function testVariant(): void
    {
        $variant = VariantFactory::new()->create();

        $discount = DiscountFactory::new()->create();
        $discount->variant()->associate($variant);

        $this->assertSame($variant->id, $discount->variant->id);
    }
}
