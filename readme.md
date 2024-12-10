# Laravel Prometheus Exporter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This package is a simple Prometheus exporter for Laravel.

## Requirements
Laravel 5.8 or higher

## Installation

Via Composer

```bash
composer require vntrungld/prometheus-exporter
```

## Usage
1. Export config
```
php artisan vendor:publish --tag prometheus-exporter.config
```
2. Edit config for your needs
3. Access metrics and get results

## First Party Collectors
1. [Horizon Collector](https://github.com/vntrungld/prometheus-exporter-horizon-collector)
2. [PHP-FPM Collector](https://github.com/vntrungld/prometheus-exporter-php-fpm-collector)

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

Will be updated soon

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Lam Duc Trung][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/vntrungld/prometheus-exporter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vntrungld/prometheus-exporter.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/vntrungld/prometheus-exporter
[link-downloads]: https://packagist.org/packages/vntrungld/prometheus-exporter
[link-author]: https://github.com/vntrungld
[link-contributors]: ../../contributors
