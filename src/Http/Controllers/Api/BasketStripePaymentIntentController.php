<?php

namespace Jskrd\Shop\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Jskrd\Shop\Http\Controllers\Controller;
use Jskrd\Shop\Models\Basket;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class BasketStripePaymentIntentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('shop.stripe.secret'));
    }

    public function store(Basket $basket): JsonResponse
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => $basket->total,
            'currency' => strtolower(config('shop.currency')),
            'metadata' => ['basket_id' => $basket->id],
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret
        ], 201);
    }
}
