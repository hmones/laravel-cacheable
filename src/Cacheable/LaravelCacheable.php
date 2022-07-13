<?php

namespace Hmones\LaravelCacheable\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelCacheable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-cacheable';
    }
}
