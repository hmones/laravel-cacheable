<?php

namespace Hmones\LaravelCacheable\Tests;

use Hmones\LaravelCacheable\CacheableServiceProvider;
use Hmones\LaravelCacheable\Tests\Classes\TestingClass;
use Orchestra\Testbench\TestCase as Test;

class CallingCachedMethodsTest extends Test
{
    public function test_items_cached_successfully(): void
    {
        $expectedReturn = 'Subscriber id is: 1';
        $methodName = 'getSubscriber';
        $cachedReturn = app(TestingClass::class)->cacheCall($methodName, ['id' => 1]);
        $this->assertEquals($expectedReturn, $cachedReturn);
        $this->assertEquals($expectedReturn, cache()->get($methodName));
        $this->assertNull(cache()->tags($methodName)->get($methodName));
    }

    public function test_user_can_use_taggable_cache(): void
    {
        config(['laravel-cacheable.cache-tags-enabled' => true]);
        $methodName = 'getSubscriber';
        $expectedReturn = 'Subscriber id is: 1';
        $cachedReturn = app(TestingClass::class)->cacheCall($methodName, ['id' => 1]);
        $this->assertEquals($expectedReturn, $cachedReturn);
        $this->assertEquals($expectedReturn, cache()->tags($methodName)->get($methodName));
        $this->assertNull(cache()->get($methodName));
    }

    public function test_user_can_add_additional_parameters_to_cache_key(): void
    {
        config(['laravel-cacheable.param-keys-enabled' => true]);
        $expectedReturn = 'Employee name is TestName and with id equals to 2';
        $cachedReturn = app(TestingClass::class)
            ->setVariable('keyPrefix', 'Prefix_')
            ->setVariable('keySuffix', '_Suffix')
            ->cacheCall('getEmployee', ['name' => 'TestName', 'id' => 2]);
        $this->assertEquals($expectedReturn, $cachedReturn);
        $this->assertEquals($expectedReturn, cache()->get('Prefix_getEmployee_Suffix.TestName.2'));
    }

    public function test_user_can_change_the_name_of_the_key_for_specific_functions(): void
    {
        config(['laravel-cacheable.param-keys-enabled' => true]);
        $expectedReturn = ['hello', 'world', 'Muller'];
        $cachedReturn = app(TestingClass::class)
            ->setVariable('keyMethodMapping', ['getManagers' => 'retrieveManagers'])
            ->cacheCall('getManagers');
        $this->assertEquals($expectedReturn, $cachedReturn);
        $this->assertEquals($expectedReturn, cache()->get('retrieveManagers'));
    }

    protected function getPackageProviders($app)
    {
        return [
            CacheableServiceProvider::class,
        ];
    }
}
