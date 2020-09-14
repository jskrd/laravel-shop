<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('addresses', AddressController::class)->only(['store', 'show', 'update', 'destroy']);

Route::apiResource('baskets', BasketController::class)->only(['store', 'show', 'update', 'destroy']);

Route::apiResource('baskets.stripe-payment-intent', BasketStripePaymentIntentController::class)->only(['store']);

Route::apiResource('baskets.variants', BasketVariantController::class);

Route::apiResource('brands', BrandController::class)->only(['index', 'show']);

Route::apiResource('countries', CountryController::class)->only(['index', 'show']);

Route::apiResource('discounts', DiscountController::class)->only(['index', 'show']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

Route::apiResource('products.images', ProductImageController::class)->only(['index']);

Route::apiResource('products.variants', ProductVariantController::class)->only(['index']);

Route::apiResource('variants', VariantController::class)->only(['index', 'show']);

Route::apiResource('variants.images', VariantImageController::class)->only(['index']);

Route::apiResource('zones', ZoneController::class)->only(['index', 'show']);
