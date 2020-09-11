<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../database/factories');
    }

    protected function getPackageProviders($app): array
    {
        return ['Jskrd\Shop\ShopServiceProvider'];
    }

    protected function getPackageAliases($app): array
    {
        return [];
    }
}
