<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Order;
use Jskrd\Shop\Models\PaypalPayment;
use Tests\TestCase;

class PaypalPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testOrder(): void
    {
        $order = factory(Order::class)->make();

        $paypalPayment = factory(PaypalPayment::class)->create();
        $paypalPayment->order()->save($order);

        $this->assertSame($order->id, $paypalPayment->order->id);
    }
}
