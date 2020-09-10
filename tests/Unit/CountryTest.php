<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Country;
use Jskrd\Shop\Models\Zone;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $country = factory(Country::class)->create();

        $this->assertRegExp($uuidPattern, $country->id);
        $this->assertFalse($country->incrementing);
    }

    public function testZone(): void
    {
        $zone = factory(Zone::class)->create();

        $country = factory(Country::class)->create();
        $country->zone()->associate($zone);

        $this->assertSame($zone->id, $country->zone->id);
    }
}
