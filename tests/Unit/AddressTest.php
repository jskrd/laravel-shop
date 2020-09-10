<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Address;
use Jskrd\Shop\Models\Basket;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $address = factory(Address::class)->create();

        $this->assertRegExp($uuidPattern, $address->id);
        $this->assertFalse($address->incrementing);
    }

    public function testBasketBilling(): void
    {
        $basket = factory(Basket::class)->make();

        $address = factory(Address::class)->create();
        $address->basketBilling()->save($basket);

        $this->assertSame($basket->id, $address->basketBilling->id);
    }

    public function testBasketDelivery(): void
    {
        $basket = factory(Basket::class)->make();

        $address = factory(Address::class)->create();
        $address->basketDelivery()->save($basket);

        $this->assertSame($basket->id, $address->basketDelivery->id);
    }
}
