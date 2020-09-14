<?php

namespace Tests\Unit;

use Database\Factories\CountryFactory;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $country = CountryFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $country->id);
        $this->assertFalse($country->incrementing);
    }

    public function testZone(): void
    {
        $zone = ZoneFactory::new()->create();

        $country = CountryFactory::new()->create();
        $country->zone()->associate($zone);

        $this->assertSame($zone->id, $country->zone->id);
    }
}
