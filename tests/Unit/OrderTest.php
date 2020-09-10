<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Basket;
use Jskrd\Shop\Models\Order;
use Jskrd\Shop\Models\StripePaymentIntent;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $order = factory(Order::class)->create();

        $this->assertRegExp($uuidPattern, $order->id);
        $this->assertFalse($order->incrementing);
    }

    public function testBasket(): void
    {
        $basket = factory(Basket::class)->create();

        $order = factory(Order::class)->create();
        $order->basket()->associate($basket);

        $this->assertSame($basket->id, $order->basket->id);
    }

    public function testPaymentable(): void
    {
        $stripePaymentIntent = factory(StripePaymentIntent::class)->create();

        $order = factory(Order::class)->create();
        $order->paymentable()->associate($stripePaymentIntent);

        $this->assertSame(
            $stripePaymentIntent->id,
            $order->paymentable->id
        );
    }
}
