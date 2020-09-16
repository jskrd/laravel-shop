<?php

namespace Tests\Feature\Api\Basket;

use Database\Factories\AddressFactory;
use Database\Factories\DiscountFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Jskrd\Shop\Models\Basket;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $this->assertSame(
            url('/shop-api/baskets'),
            route('shop-api.baskets.store')
        );
    }

    public function testBillingAddressIdNullable(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'billing_address_id' => '',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonMissingValidationErrors('billing_address_id');
    }

    public function testBillingAddressIdString(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'billing_address_id' => 1,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'billing_address_id' => 'The billing address id must be a string.'
            ]);
    }

    public function testBillingAddressIdUuid(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'billing_address_id' => '1',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'billing_address_id' => 'The billing address id must be a valid UUID.'
            ]);
    }

    public function testBillingAddressIdExists(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'billing_address_id' => Str::uuid(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'billing_address_id' => 'The selected billing address id is invalid.'
            ]);
    }

    public function testDeliveryAddressIdNullable(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'delivery_address_id' => '',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonMissingValidationErrors('delivery_address_id');
    }

    public function testDeliveryAddressIdString(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'delivery_address_id' => 1,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'delivery_address_id' => 'The delivery address id must be a string.'
            ]);
    }

    public function testDeliveryAddressIdUuid(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'delivery_address_id' => '1',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'delivery_address_id' => 'The delivery address id must be a valid UUID.'
            ]);
    }

    public function testDeliveryAddressIdExists(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'delivery_address_id' => Str::uuid(),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'delivery_address_id' => 'The selected delivery address id is invalid.'
            ]);
    }

    public function testDiscountIdNullable(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'discount_id' => '',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonMissingValidationErrors('discount_id');
    }

    public function testDiscountIdString(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'discount_id' => 1,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'discount_id' => 'The discount id must be a string.'
            ]);
    }

    public function testDiscountIdMax(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'discount_id' => str_repeat('a', 256),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'discount_id' => 'The discount id may not be greater than 255 characters.'
            ]);
    }

    public function testDiscountIdExists(): void
    {
        $response = $this->postJson(route('shop-api.baskets.store'), [
            'discount_id' => Str::random(10),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'discount_id' => 'The selected discount id is invalid.'
            ]);
    }

    public function testStored(): void
    {
        $discount = DiscountFactory::new()->create();
        $billingAddress = AddressFactory::new()->create();
        $deliveryAddress = AddressFactory::new()->create();

        $response = $this->postJson(route('shop-api.baskets.store'), [
            'billing_address_id' => $billingAddress->id,
            'delivery_address_id' => $deliveryAddress->id,
            'discount_id' => $discount->id,
        ]);

        $basket = Basket::first();

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => $basket->id,
                    'status' => $basket->status,
                    'variants_count' => $basket->variants_count,
                    'subtotal' => $basket->subtotal,
                    'discount_amount' => $basket->discount_amount,
                    'delivery_cost' => $basket->delivery_cost,
                    'total' => $basket->total,
                    'billing_address_id' => $billingAddress->id,
                    'delivery_address_id' => $deliveryAddress->id,
                    'discount_id' => $discount->id,
                    'created_at' => $basket->created_at->toISOString(),
                    'updated_at' => $basket->updated_at->toISOString(),
                ],
            ]);
    }
}
