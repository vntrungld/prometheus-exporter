<?php

return [
    'enabled' => env('PROMETHEUS_EXPORTER_ENABLED', true),
    'namespace' => env('PROMETHEUS_EXPORTER_NAMESPACE', 'laravel'),
    'path' => env('PROMETHEUS_EXPORTER_PATH', 'metrics'),
    'token' => env('PROMETHEUS_EXPORTER_TOKEN'),
    'middleware' => [
        \Vntrungld\PrometheusExporter\Middlewares\Authorize::class,
    ],
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
