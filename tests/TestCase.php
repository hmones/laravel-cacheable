<?php

namespace Hmones\LaravelCacheable\Tests;

use Hmones\LaravelCacheable\LaravelCacheableServiceProvider;
use Orchestra\Testbench\TestCase as Test;

class TestCase extends Test
{
    public function test_success(): void
    {
        $this->assertTrue(true);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelCacheableServiceProvider::class,
        ];
    }
}
