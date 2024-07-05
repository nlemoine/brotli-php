[![PHP unit tests](https://github.com/nlemoine/brotli-php/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/nlemoine/brotli-php/actions/workflows/tests.yml?query=branch:2.x)
![Packagist Downloads](https://img.shields.io/packagist/dt/n5s/brotli)

This library adds Brotli support to PHP. Batteries included.

```php
function brotli_compress(string $data, int $quality = 11): string

function brotli_uncompress(string $data): string
```

It is a fork of [vdechenaux/brotli-php](https://github.com/vdechenaux/brotli-php). Main differences:

- avoid usage of `ob_start` in [`\Symfony\Component\Process\Process`](https://github.com/symfony/process/blob/b8d6eff26e48187fed15970799f4b605fa7242e4/Process.php#L1383-L1386) so you can use it inside an `ob_start` callback.
- comes with prebuilt binaries from https://github.com/nlemoine/local-bin-brotli and automatic system guessing

## Installation

```bash
composer require n5s/brotli
```

## Binaries

### `brotli` is not available on your system/server

Prebuilt binaries included for the following systems:

- Linux (x86_64/i386)
- Mac OS
- Windows

### `brotli` is available on your system/server

If `brotli` is available on your server, you set its path using:

```
\n5s\Brotli\Brotli::setBinaryPath('brotli');
```

or

```
\n5s\Brotli\Brotli::setBinaryPath('/some/dir/brotli');
```

## Tests

```
composer test
```
