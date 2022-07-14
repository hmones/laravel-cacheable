<?php

return [
    'param-keys-enabled' => env('CACHEABLE_PARAM_KEYS_ENABLED', false),
    'ttl'                => env('CACHEABLE_TTL', 3600),
    'prefix'             => env('CACHEABLE_PREFIX', ''),
    'suffix'             => env('CACHEABLE_SUFFFIX', ''),
    'cache-tags-enabled' => env('CACHEABLE_TAGS', false),
];
