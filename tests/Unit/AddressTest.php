<?php

namespace Tests\Unit;

use Database\Factories\AddressFactory;
use Database\Factories\BasketFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $address = AddressFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $address->id);
        $this->assertFalse($address->incrementing);
    }

    public function testBasketBilling(): void
    {
        $basket = BasketFactory::new()->make();

        $address = AddressFactory::new()->create();
        $address->basketBilling()->save($basket);

        $this->assertSame($basket->id, $address->basketBilling->id);
    }

    public function testBasketDelivery(): void
    {
        $basket = BasketFactory::new()->make();

        $address = AddressFactory::new()->create();
        $address->basketDelivery()->save($basket);

        $this->assertSame($basket->id, $address->basketDelivery->id);
    }
}
