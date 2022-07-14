<?php

namespace Hmones\LaravelCacheable;

use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class Cacheable
{
    protected array $keyMethodMapping = [];
    protected string $keyPrefix;
    protected string $keySuffix;
    protected int $cacheTtl;
    protected bool $addParametersToKey;

    public function cacheCall(string $name, array $arguments = [])
    {
        if (!method_exists($this, $name)) {
            throw new MethodNotFoundException('The method does not exist in the class', get_class($this), $name);
        }

        return $this->isTagEnabled()
            ? Cache::tags($this->getCacheTag($name))->remember($this->getCacheKey($name, $arguments), $this->getCacheTtl(), fn () => $this->$name(...array_values($arguments)))
            : Cache::remember($this->getCacheKey($name, $arguments), $this->getCacheTtl(), fn () => $this->$name(...array_values($arguments)));
    }

    public function forgetCall(string $name, array $arguments = []): bool
    {
        return $this->isTagEnabled()
            ? Cache::tags($this->getCacheTag($name))->flush()
            : Cache::forget($this->getCacheKey($name, $arguments));
    }

    private function isTagEnabled(): bool
    {
        return config('laravel-cacheable.cache-tags-enabled', false) && Cache::getStore() instanceof TaggableStore;
    }

    private function getCacheTag(string $name): string
    {
        return  $this->getPrefix().data_get($this->keyMethodMapping, $name, $name).$this->getSuffix();
    }

    private function getCacheKey(string $name, array $arguments): string
    {
        return $this->getCacheTag($name).$this->getStringParameters($arguments);
    }

    private function getStringParameters(array $arguments): string
    {
        return ($this->addParametersToKey ?? config('laravel-cacheable.param-keys-enabled', false)) && !empty($arguments)
            ? '.'.implode('.', $arguments)
            : '';
    }

    private function getPrefix(): string
    {
        return $this->keyPrefix ?? config('laravel-cacheable.prefix', '');
    }

    private function getSuffix(): string
    {
        return $this->keySuffix ?? config('laravel-cacheable.suffix', '');
    }

    private function getCacheTtl(): int
    {
        return $this->cacheTtl ?? config('laravel-cacheable.ttl', 3600);
    }
}
