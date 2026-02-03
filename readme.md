# Laravel Prometheus Exporter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Tests][ico-tests]][link-tests]

A simple and extensible Prometheus metrics exporter for Laravel applications.

## Requirements

- PHP 7.4, 8.0, 8.1, 8.2, 8.3, or 8.4
- Laravel 6.x, 7.x, 8.x, 9.x, 10.x, 11.x, or 12.x

## Installation

Install via Composer:

```bash
composer require vntrungld/prometheus-exporter
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=prometheus-exporter.config
```

## Configuration

The configuration file will be published to `config/prometheus-exporter.php`:

```php
return [
    // Enable or disable the exporter
    'enabled' => env('PROMETHEUS_EXPORTER_ENABLED', true),

    // Metric namespace prefix
    'namespace' => env('PROMETHEUS_EXPORTER_NAMESPACE', 'laravel'),

    // Endpoint path (e.g., /metrics)
    'path' => env('PROMETHEUS_EXPORTER_PATH', 'metrics'),

    // Optional security token
    'token' => env('PROMETHEUS_EXPORTER_TOKEN'),

    // Middleware for the metrics endpoint
    'middleware' => [
        \Vntrungld\PrometheusExporter\Middlewares\Authorize::class,
    ],

    // Tier-based collector configuration (useful for K8s deployments)
    'tier' => env('PROMETHEUS_EXPORTER_TIER', 'default'),

    'tiers' => [
        'default' => [
            'collectors' => [
                \Vntrungld\PrometheusExporter\Collectors\TestCollector::class,
            ],
            'sets' => [],
        ],
    ],
];
```

## Usage

### Accessing Metrics

Once installed, metrics are available at the configured endpoint:

```
GET /metrics
```

If you've configured a security token:

```
GET /metrics?token=your-token
```

### Creating Custom Collectors

Create a collector by implementing the `Collector` interface:

```php
<?php

namespace App\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class RequestsCollector implements Collector
{
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('http_requests_total')
            ->help('Total number of HTTP requests')
            ->labels(['method', 'status'])
            ->value(100, ['GET', '200'])
            ->value(50, ['POST', '201']);
    }
}
```

Register your collector in the configuration:

```php
'tiers' => [
    'default' => [
        'collectors' => [
            \App\Collectors\RequestsCollector::class,
        ],
        'sets' => [],
    ],
],
```

### Metric Types

#### Counter

A counter is a cumulative metric that only increases:

```php
$prometheus->addCounter('jobs_processed_total')
    ->help('Total number of processed jobs')
    ->labels(['queue'])
    ->value(150, ['default'])
    ->value(75, ['emails']);
```

#### Gauge

A gauge represents a value that can go up or down:

```php
$prometheus->addGauge('queue_size')
    ->help('Current queue size')
    ->labels(['queue'])
    ->value(42, ['default']);
```

#### Histogram

A histogram samples observations and counts them in configurable buckets:

```php
$prometheus->addHistogram('http_request_duration_seconds')
    ->help('HTTP request duration in seconds')
    ->labels(['endpoint'])
    ->value(0.25, ['/api/users']);
```

#### Summary

A summary samples observations and provides quantiles:

```php
$prometheus->addSummary('http_request_duration_summary')
    ->help('HTTP request duration summary')
    ->labels(['endpoint'])
    ->value(0.25, ['/api/users']);
```

### Collector Sets

Group related collectors using the `CollectorSet` interface:

```php
<?php

namespace App\Collectors;

use Vntrungld\PrometheusExporter\Collectors\CollectorSet;

class ApiCollectorSet implements CollectorSet
{
    public function collectors(): array
    {
        return [
            RequestsCollector::class,
            ResponseTimeCollector::class,
            ErrorsCollector::class,
        ];
    }
}
```

Register the set in configuration:

```php
'tiers' => [
    'api' => [
        'collectors' => [],
        'sets' => [
            \App\Collectors\ApiCollectorSet::class,
        ],
    ],
],
```

### Multi-Tier Configuration

For Kubernetes deployments with multiple application tiers:

```php
'tier' => env('PROMETHEUS_EXPORTER_TIER', 'default'),

'tiers' => [
    'default' => [
        'collectors' => [TestCollector::class],
        'sets' => [],
    ],
    'api' => [
        'collectors' => [],
        'sets' => [ApiCollectorSet::class],
    ],
    'worker' => [
        'collectors' => [],
        'sets' => [WorkerCollectorSet::class],
    ],
],
```

Set the tier via environment variable:

```bash
PROMETHEUS_EXPORTER_TIER=api
```

### Using the Facade

You can also use the Prometheus facade directly:

```php
use Vntrungld\PrometheusExporter\Facades\Prometheus;

Prometheus::addCounter('custom_metric')
    ->help('A custom metric')
    ->value(1);
```

## Security

### Token Authentication

Set a security token to protect your metrics endpoint:

```bash
PROMETHEUS_EXPORTER_TOKEN=your-secret-token
```

Access metrics with the token:

```
GET /metrics?token=your-secret-token
```

### Custom Middleware

Add your own middleware for additional security:

```php
'middleware' => [
    \Vntrungld\PrometheusExporter\Middlewares\Authorize::class,
    \App\Http\Middleware\IpWhitelist::class,
],
```

## First Party Collectors

- [Horizon Collector](https://github.com/vntrungld/prometheus-exporter-horizon-collector) - Laravel Horizon metrics
- [PHP-FPM Collector](https://github.com/vntrungld/prometheus-exporter-php-fpm-collector) - PHP-FPM pool metrics

## Testing

Run the test suite:

```bash
composer test
```

Or directly with PHPUnit:

```bash
vendor/bin/phpunit
```

## Changelog

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email vn.trungld@gmail.com instead of using the issue tracker.

## Credits

- [Lam Duc Trung][link-author]
- [All Contributors][link-contributors]

## License

MIT License. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/vntrungld/prometheus-exporter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/vntrungld/prometheus-exporter.svg?style=flat-square
[ico-tests]: https://github.com/vntrungld/prometheus-exporter/workflows/Tests/badge.svg

[link-packagist]: https://packagist.org/packages/vntrungld/prometheus-exporter
[link-downloads]: https://packagist.org/packages/vntrungld/prometheus-exporter
[link-tests]: https://github.com/vntrungld/prometheus-exporter/actions?query=workflow%3ATests
[link-author]: https://github.com/vntrungld
[link-contributors]: ../../contributors
