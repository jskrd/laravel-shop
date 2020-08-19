<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('addresses', 'AddressController')
    ->only(['store', 'show', 'update', 'destroy']);

Route::apiResource('baskets', 'BasketController')->only(['store', 'show']);

Route::apiResource('baskets.variants', 'BasketVariantController');

Route::apiResource('products', 'ProductController')->only(['index', 'show']);

Route::apiResource('products.images', 'ProductImageController')
    ->only(['index']);

Route::apiResource('products.variants', 'ProductVariantController')
    ->only(['index']);

Route::apiResource('variants', 'VariantController')->only(['show']);

Route::apiResource('variants.images', 'VariantImageController')
    ->only(['index']);
