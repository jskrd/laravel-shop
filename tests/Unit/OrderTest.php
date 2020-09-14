<?php

namespace Tests\Unit;

use Database\Factories\BasketFactory;
use Database\Factories\OrderFactory;
use Database\Factories\StripePaymentIntentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $order = OrderFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $order->id);
        $this->assertFalse($order->incrementing);
    }

    public function testBasket(): void
    {
        $basket = BasketFactory::new()->create();

        $order = OrderFactory::new()->create();
        $order->basket()->associate($basket);

        $this->assertSame($basket->id, $order->basket->id);
    }

    public function testPaymentable(): void
    {
        $stripePaymentIntent = StripePaymentIntentFactory::new()->create();

        $order = OrderFactory::new()->create();
        $order->paymentable()->associate($stripePaymentIntent);

        $this->assertSame(
            $stripePaymentIntent->id,
            $order->paymentable->id
        );
    }
}
