<?php

namespace Tests\Unit;

use Database\Factories\AddressFactory;
use Database\Factories\BasketFactory;
use Database\Factories\CountryFactory;
use Database\Factories\DiscountFactory;
use Database\Factories\OrderFactory;
use Database\Factories\VariantFactory;
use Database\Factories\ZoneFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Jskrd\Shop\Models\Basket;
use Tests\TestCase;

class BasketTest extends TestCase
{
    use RefreshDatabase;

    public function testIdentifies(): void
    {
        $uuidPattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89aAbB][a-f0-9]{3}-[a-f0-9]{12}$/';

        $basket = BasketFactory::new()->create();

        $this->assertMatchesRegularExpression($uuidPattern, $basket->id);
        $this->assertFalse($basket->incrementing);
    }

    public function testAttributes(): void
    {
        $basket = Basket::create();

        $this->assertSame(0, $basket->discount_amount);
        $this->assertSame(0, $basket->delivery_cost);
    }

    public function testBillingAddress(): void
    {
        $billingAddress = AddressFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->billingAddress()->associate($billingAddress);

        $this->assertSame($billingAddress->id, $basket->billingAddress->id);
    }

    public function testDeliveryAddress(): void
    {
        $deliveryAddress = AddressFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->deliveryAddress()->associate($deliveryAddress);

        $this->assertSame($deliveryAddress->id, $basket->deliveryAddress->id);
    }

    public function testDiscount(): void
    {
        $discount = DiscountFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->discount()->associate($discount);

        $this->assertSame($discount->id, $basket->discount->id);
    }

    public function testCalculateDeliveryCostWithoutDeliveryAddress(): void
    {
        $basket = Basket::create();

        $this->assertSame(0, $basket->calculateDeliveryCost());
    }

    public function testCalculateDeliveryCostWithoutVariants(): void
    {
        $basket = Basket::create();
        $basket->deliveryAddress()->associate(
            AddressFactory::new()->create(['country' => 'GB'])
        );

        $this->assertSame(0, $basket->calculateDeliveryCost());
    }

    public function testCalculateDeliveryCostWithoutZones(): void
    {
        $variant = VariantFactory::new()->create(['delivery_cost' => 940]);

        $basket = Basket::create();
        $basket->deliveryAddress()->associate(
            AddressFactory::new()->create(['country' => 'GB'])
        );

        $basket->variants()->attach($variant, [
            'customizations' => [],
            'quantity' => 2,
            'price' => 0,
        ]);

        $this->assertSame(1880, $basket->calculateDeliveryCost());
    }

    public function testCalculateDeliveryCostOutsideZone(): void
    {
        $zone = ZoneFactory::new()->create(['name' => 'Europe']);

        $variant = VariantFactory::new()->create(['delivery_cost' => 940]);
        $variant->zones()->attach($zone, ['delivery_cost' => 667]);

        $basket = Basket::create();
        $basket->deliveryAddress()->associate(
            AddressFactory::new()->create(['country' => 'GB'])
        );

        $basket->variants()->attach($variant, [
            'customizations' => [],
            'quantity' => 2,
            'price' => 0,
        ]);

        $this->assertSame(1880, $basket->calculateDeliveryCost());
    }

    public function testCalculateDeliveryCostInsideZone(): void
    {
        $zone = ZoneFactory::new()->create(['name' => 'Europe']);

        $country = CountryFactory::new()->make(['alpha2' => 'GB']);
        $country->zone()->associate($zone);
        $country->save();

        $variant = VariantFactory::new()->create(['delivery_cost' => 940]);
        $variant->zones()->attach($zone, ['delivery_cost' => 667]);

        $basket = Basket::create();
        $basket->deliveryAddress()->associate(
            AddressFactory::new()->create(['country' => 'GB'])
        );

        $basket->variants()->attach($variant, [
            'customizations' => [],
            'quantity' => 2,
            'price' => 0,
        ]);

        $this->assertSame(1334, $basket->calculateDeliveryCost());
    }

    public function testCalculateDiscountAmountWithoutDiscount(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();
        $basket->variants()->attach([
            $variants[0]->id => ['customizations' => [], 'quantity' => 1, 'price' => 1499],
            $variants[1]->id => ['customizations' => [], 'quantity' => 2, 'price' => 999]
        ]);

        $this->assertSame(0, $basket->calculateDiscountAmount());
    }

    public function testCalculateDiscountAmountPercent(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();
        $basket->variants()->attach([
            $variants[0]->id => ['customizations' => [], 'quantity' => 1, 'price' => 1499],
            $variants[1]->id => ['customizations' => [], 'quantity' => 2, 'price' => 999]
        ]);

        $discount = DiscountFactory::new()->create([
            'percent' => 90,
            'maximum' => null,
            'variant_id' => null,
        ]);

        $basket->discount()->associate($discount);
        $basket->save();

        $this->assertSame(3147, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 100]);

        $this->assertSame(3497, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 110]);

        $this->assertSame(3497, $basket->calculateDiscountAmount());
    }

    public function testCalculateDiscountAmountMaximum(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();
        $basket->variants()->attach([
            $variants[0]->id => ['customizations' => [], 'quantity' => 1, 'price' => 1499],
            $variants[1]->id => ['customizations' => [], 'quantity' => 2, 'price' => 999]
        ]);

        $discount = DiscountFactory::new()->create([
            'percent' => 50,
            'maximum' => null,
            'variant_id' => null,
        ]);

        $basket->discount()->associate($discount);
        $basket->save();

        $this->assertSame(1749, $basket->calculateDiscountAmount());

        $discount->update(['maximum' => 500]);

        $this->assertSame(500, $basket->calculateDiscountAmount());
    }

    public function testCalculateDiscountAmountVariantPercent(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();
        $basket->variants()->attach([
            $variants[0]->id => ['customizations' => [], 'quantity' => 1, 'price' => 1499],
            $variants[1]->id => ['customizations' => [], 'quantity' => 2, 'price' => 999]
        ]);

        $discount = DiscountFactory::new()->create([
            'percent' => 90,
            'maximum' => null,
            'variant_id' => $variants[0]->id,
        ]);

        $basket->discount()->associate($discount);
        $basket->save();

        $this->assertSame(1349, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 100]);
        $this->assertSame(1499, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 110]);
        $this->assertSame(1499, $basket->calculateDiscountAmount());

        $discount->variant()->associate($variants[1]);
        $discount->save();

        $discount->update(['percent' => 90]);
        $this->assertSame(1798, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 100]);
        $this->assertSame(1998, $basket->calculateDiscountAmount());

        $discount->update(['percent' => 110]);
        $this->assertSame(1998, $basket->calculateDiscountAmount());
    }

    public function testCalculateDiscountAmountVariantMaximum(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();
        $basket->variants()->attach([
            $variants[0]->id => ['customizations' => [], 'quantity' => 1, 'price' => 1499],
            $variants[1]->id => ['customizations' => [], 'quantity' => 2, 'price' => 999]
        ]);

        $discount = DiscountFactory::new()->create([
            'percent' => 50,
            'maximum' => null,
            'variant_id' => $variants[0]->id,
        ]);

        $basket->discount()->associate($discount);
        $basket->save();

        $this->assertSame(750, $basket->calculateDiscountAmount());

        $discount->update(['maximum' => 500]);
        $this->assertSame(500, $basket->calculateDiscountAmount());

        $discount->variant()->associate($variants[1]);
        $discount->save();

        $discount->update(['maximum' => null]);
        $this->assertSame(999, $basket->calculateDiscountAmount());

        $discount->update(['maximum' => 500]);
        $this->assertSame(500, $basket->calculateDiscountAmount());
    }

    public function testGetStatusAttributeOrdered(): void
    {
        $basket = Basket::create();

        $order = OrderFactory::new()->make();
        $order->basket()->associate($basket);
        $order->save();

        $this->assertSame('ordered', $basket->status);
    }

    public function testGetStatusAttributeEmpty(): void
    {
        $basket = Basket::create();

        $this->assertSame('empty', $basket->status);
    }

    public function testGetStatusAttributeAwaitingDeliveryAddress(): void
    {
        $variant = VariantFactory::new()->create();

        $basket = Basket::create();
        $basket->variants()->attach($variant->id, [
            'customizations' => [],
            'quantity' => 1,
            'price' => 0,
        ]);

        $this->assertSame('awaiting_delivery_address', $basket->status);
    }

    public function testGetStatusAttributeAwaitingBillingAddress(): void
    {
        $deliveryAddress = AddressFactory::new()->create();

        $variant = VariantFactory::new()->create();

        $basket = Basket::create();
        $basket->variants()->attach($variant->id, [
            'customizations' => [],
            'quantity' => 1,
            'price' => 0,
        ]);

        $basket->deliveryAddress()->associate($deliveryAddress);
        $basket->save();

        $this->assertSame('awaiting_billing_address', $basket->status);
    }

    public function testGetStatusAttributeOrderable(): void
    {
        $billingAddress = AddressFactory::new()->create();
        $deliveryAddress = AddressFactory::new()->create();

        $variant = VariantFactory::new()->create();

        $basket = Basket::create();
        $basket->variants()->attach($variant->id, [
            'customizations' => [],
            'quantity' => 1,
            'price' => 0,
        ]);

        $basket->billingAddress()->associate($billingAddress);
        $basket->deliveryAddress()->associate($deliveryAddress);
        $basket->save();

        $this->assertSame('orderable', $basket->status);
    }

    public function testGetSubtotalAttribute(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = BasketFactory::new()->create();

        $basket->variants()->attach([
            $variants[0]->id => [
                'customizations' => [],
                'quantity' => 3,
                'price' => 8612,
            ],
            $variants[1]->id => [
                'customizations' => [],
                'quantity' => 1,
                'price' => 3110,
            ],
        ]);

        $this->assertSame(28946, $basket->subtotal);
    }

    public function testGetTotalAttribute(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = BasketFactory::new()->create([
            'discount_amount' => 441,
            'delivery_cost' => 478
        ]);

        $basket->variants()->attach([
            $variants[0]->id => [
                'customizations' => [],
                'quantity' => 3,
                'price' => 8612,
            ],
            $variants[1]->id => [
                'customizations' => [],
                'quantity' => 1,
                'price' => 3110,
            ],
        ]);

        $this->assertSame(28983, $basket->total);
    }

    public function testGetVariantsCountAttributeWithoutVariants(): void
    {
        $basket = Basket::create();

        $this->assertSame(0, $basket->variants_count);
    }

    public function testGetVariantsCountAttributeWithVariants(): void
    {
        $variants = VariantFactory::new()->count(2)->create();

        $basket = Basket::create();

        $basket->variants()->attach([
            $variants[0]->id => [
                'customizations' => [],
                'quantity' => 2,
                'price' => 0,
            ],
            $variants[1]->id => [
                'customizations' => [],
                'quantity' => 1,
                'price' => 0,
            ],
        ]);

        $this->assertSame(3, $basket->variants_count);
    }

    public function testOrder(): void
    {
        $order = OrderFactory::new()->make();

        $basket = BasketFactory::new()->create();
        $basket->order()->save($order);

        $this->assertSame($order->id, $basket->order->id);
    }

    public function testVariants(): void
    {
        $variant = VariantFactory::new()->create();

        $basket = BasketFactory::new()->create();
        $basket->variants()->attach($variant, [
            'customizations' => [],
            'quantity' => 7,
            'price' => 6813,
        ]);

        $this->assertSame($variant->id, $basket->variants[0]->id);
        $this->assertSame(7, $basket->variants[0]->pivot->quantity);
        $this->assertSame(6813, $basket->variants[0]->pivot->price);
    }
}
