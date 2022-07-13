<h1 align="center">Laravel Cacheable</h1>

<p align="center">
<a href="https://github.com/hmones/laravel-cacheable/actions"><img src="https://github.com/hmones/laravel-cacheable/actions/workflows/build.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.styleci.io/repos/450457021"><img src="https://github.styleci.io/repos/450457021/shield" alt="Style CI"></a>
<a href="https://packagist.org/packages/hmones/laravel-cacheable"><img src="http://poser.pugx.org/hmones/laravel-cacheable/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/hmones/laravel-cacheable"><img src="https://img.shields.io/github/v/release/hmones/laravel-cacheable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/hmones/laravel-cacheable"><img src="http://poser.pugx.org/hmones/laravel-cacheable/license" alt="License"></a>
</p>

A simple package to cache returns of certain methods and forgets them with specific setting

## Installation

Via Composer

```bash
composer require hmones/laravel-cacheable
```

## Configuration

To publish the package configuration

```bash
php artisan vendor:publish --tag=laravel-cacheable-config
 ```

The configuration file contains the following parameters:
- `ttl`: the default time to live for caching functions
  - Env variable: `CACHEABLE_TTL`
  - Default value: `3600`
- `param-keys-enabled` whether you would like to add function parameters to keys of the stored cache items
  - Env variable: `CACHEABLE_PARAM_KEYS_ENABLED`
  - Default value: `true`
- `prefix` if you would like to set a default prefix to all cacheable items
  - Env variable: `CACHEABLE_PREFIX`
  - Default value: ``
- `suffix` if you would like to set a default suffix to all cacheable items
  - Env variable: `CACHEABLE_SUFFFIX`
  - Default value: ``


## Usage

- Make sure your class extend `\Hmones\LaravelCacheable\Cacheable`
- Instead of calling the method in the class directly, call `CLASS::cacheCall('methodName', ['argument1' => 'value', 'argument2' => 'value'])`
- You can remove the cached method call as follows:
  - If you have redis and tagging enabled cache driver, even if you have enabled the parameters addition to cache keys, you can simply call `CLASS::forgetCall('methodName)`
  - If you don't have a cache driver that supports tags and you have enabled adding functions parameters to the cache, you must include the arguments in the forget call as follows: `CLASS::forgetCall('methodName', ['argument1' => 'value', 'argument2' => 'value'])`

Example: Sending a digest email every time 10 new users register on the website with a summary of their names.

## Change log

Please see the [changelog](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [contributing.md](CONTRIBUTING.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits
- [Haytham Mones][link-author]

## License

Please see the [license file](LICENSE.md) for more information.

[link-author]: https://github.com/hmones
