<?php

namespace Tests\Unit;

use Database\Factories\CountryFactory;
use Database\Factories\VariantFactory;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $zone = ZoneFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $zone->id);
        $this->assertFalse($zone->incrementing);
    }

    public function testCountries(): void
    {
        $country = CountryFactory::new()->make();

        $zone = ZoneFactory::new()->create();
        $zone->countries()->save($country);

        $this->assertSame($country->id, $zone->countries[0]->id);
    }

    public function testVariants(): void
    {
        $variant = VariantFactory::new()->create();

        $zone = ZoneFactory::new()->create();
        $zone->variants()->attach($variant, ['delivery_cost' => 175]);

        $this->assertSame($variant->id, $zone->variants[0]->id);
        $this->assertSame(175, $zone->variants[0]->pivot->delivery_cost);
    }
}
