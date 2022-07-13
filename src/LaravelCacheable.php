<?php

namespace Hmones\LaravelCacheable;

use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class LaravelCacheable
{
    public array $keyMethodMapping = [];
    public string $keyPrefix;
    public string $keySuffix;
    public int $cacheTtl;
    public bool $addParametersToKey;

    public function __construct()
    {
        $this->keyPrefix = config('laravel-cacheable.prefix', '');
        $this->keySuffix = config('laravel-cacheable.suffix', '');
        $this->cacheTtl = config('laravel-cacheable.ttl', 3600);
        $this->addParametersToKey = config('laravel-cacheable.param-keys-enabled', false);
    }

    public function cachedCall(string $name, array $arguments = []): mixed
    {
        if (!method_exists($this, $name)) {
            throw new MethodNotFoundException('The method does not exist in the class', get_class($this), $name);
        }

        return $this->isCacheTaggable()
            ? Cache::tags($this->getCacheTag($name))->remember($this->getCacheKey($name, $arguments), $this->cacheTtl, fn() => $this->$name(...$arguments))
            : Cache::remember($this->getCacheKey($name, $arguments), $this->cacheTtl, fn() => $this->$name(...$arguments));
    }

    public function forgetCall(string $name, array $arguments = []): bool
    {
        return $this->isCacheTaggable()
            ? Cache::tags($this->getCacheTag($name))->flush()
            : Cache::forget($this->getCacheKey($name, $arguments));
    }

    private function isCacheTaggable(): bool
    {
        return Cache::getStore() instanceof TaggableStore;
    }

    private function getCacheTag(string $name): string
    {
        return $this->keyPrefix . data_get($this->keyMethodMapping, $name, $name) . $this->keySuffix;
    }

    private function getCacheKey(string $name, array $arguments): string
    {
        return $this->getCacheTag($name) . ($this->addParametersToKey && !empty($arguments) ? '.' . implode('.', $arguments) : '');
    }
}