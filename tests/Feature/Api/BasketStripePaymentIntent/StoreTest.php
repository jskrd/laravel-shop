<?php

namespace Tests\Feature\Api\BasketStripePaymentIntent;

use Database\Factories\BasketFactory;
use Database\Factories\VariantFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $id . '/stripe-payment-intent'),
            route('shop-api.baskets.stripe-payment-intent.store', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->postJson(
            route('shop-api.baskets.stripe-payment-intent.store', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testStored(): void
    {
        $variant = VariantFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->variants()->attach($variant, [
            'customizations' => [],
            'quantity' => 1,
            'price' => 10000,
        ]);

        $response = $this->postJson(
            route('shop-api.baskets.stripe-payment-intent.store', $basket)
        );

        $data = $response->decodeResponseJson();

        $response
            ->assertStatus(201)
            ->assertJson([
                'client_secret' => $data['client_secret'],
            ]);

        preg_match('/^pi_[0-9A-Za-z]+/', $data['client_secret'], $matches);
        $paymentIntentId = $matches[0];

        $stripe = new StripeClient(config('shop.stripe.secret'));

        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

        $this->assertSame($basket->total, $paymentIntent->amount);
        $this->assertSame('gbp', $paymentIntent->currency);
        $this->assertSame($basket->id, $paymentIntent->metadata['basket_id']);
    }
}
