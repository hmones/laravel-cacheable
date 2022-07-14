<?php

namespace Hmones\LaravelCacheable;

use Illuminate\Support\ServiceProvider;

class CacheableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-cacheable.php', 'laravel-cacheable');
    }

    public function provides(): array
    {
        return ['laravel-cacheable'];
    }

    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-cacheable.php' => config_path('laravel-cacheable.php'),
        ], 'laravel-cacheable.config');
    }
}
