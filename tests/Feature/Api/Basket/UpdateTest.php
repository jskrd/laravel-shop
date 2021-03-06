<?php

namespace Tests\Feature\Api\Basket;

use Database\Factories\AddressFactory;
use Database\Factories\BasketFactory;
use Database\Factories\DiscountFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testRoute(): void
    {
        $id = Str::uuid();

        $this->assertSame(
            url('/shop-api/baskets/' . $id),
            route('shop-api.baskets.update', $id)
        );
    }

    public function testNotFound(): void
    {
        $response = $this->putJson(
            route('shop-api.baskets.update', Str::uuid())
        );

        $response->assertNotFound();
    }

    public function testBillingAddressIdNullable(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
            'billing_address_id' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonMissingValidationErrors('billing_address_id');
    }

    public function testBillingAddressIdString(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
            'delivery_address_id' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonMissingValidationErrors('delivery_address_id');
    }

    public function testDeliveryAddressIdString(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
            'discount_id' => '',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonMissingValidationErrors('discount_id');
    }

    public function testDiscountIdString(): void
    {
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
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
        $basket = BasketFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
            'discount_id' => Str::random(10),
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'discount_id' => 'The selected discount id is invalid.'
            ]);
    }

    public function testUpdated(): void
    {
        $basket = BasketFactory::new()->create();

        $discount = DiscountFactory::new()->create();
        $billingAddress = AddressFactory::new()->create();
        $deliveryAddress = AddressFactory::new()->create();

        $response = $this->putJson(route('shop-api.baskets.update', $basket), [
            'billing_address_id' => $billingAddress->id,
            'delivery_address_id' => $deliveryAddress->id,
            'discount_id' => $discount->id,
        ]);

        $basket->refresh();

        $response
            ->assertStatus(200)
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
