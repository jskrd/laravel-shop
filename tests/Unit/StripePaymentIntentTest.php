<?php

namespace Tests\Unit;

use Database\Factories\OrderFactory;
use Database\Factories\StripePaymentIntentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripePaymentIntentTest extends TestCase
{
    use RefreshDatabase;

    public function testOrder(): void
    {
        $order = OrderFactory::new()->make();

        $stripePaymentIntent = StripePaymentIntentFactory::new()->create();
        $stripePaymentIntent->order()->save($order);

        $this->assertSame(
            $order->id,
            $stripePaymentIntent->order->id
        );
    }
}
