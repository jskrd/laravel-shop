<?php

namespace Tests\Unit;

use Database\Factories\OrderFactory;
use Database\Factories\PaypalPaymentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaypalPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testOrder(): void
    {
        $order = OrderFactory::new()->make();

        $paypalPayment = PaypalPaymentFactory::new()->create();
        $paypalPayment->order()->save($order);

        $this->assertSame($order->id, $paypalPayment->order->id);
    }
}
