<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Prometheus Exporter
    |--------------------------------------------------------------------------
    |
    | This option controls whether the Prometheus exporter is enabled.
    | Default: true
    |
    */
    
    'enabled' => env('PROMETHEUS_EXPORTER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | This option controls the namespace of the metrics.
    | Default: laravel
    |
    */
    
    'namespace' => env('PROMETHEUS_EXPORTER_NAMESPACE', 'laravel'),

    /*
    |--------------------------------------------------------------------------
    | Metrics Path
    |--------------------------------------------------------------------------
    |
    | This option controls the path to access the metrics.
    | Default: metrics
    |
    */
    
    'path' => env('PROMETHEUS_EXPORTER_PATH', 'metrics'),

    /*
    |--------------------------------------------------------------------------
    | Security Token
    |--------------------------------------------------------------------------
    |
    | This option controls the security token to access the metrics.
    | Eg: metrics?token=your-token
    |
    */
    
    'token' => env('PROMETHEUS_EXPORTER_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | This option controls the middleware to authorize the access to the metrics.
    |
    */
    
    'middleware' => [
        \Vntrungld\PrometheusExporter\Middlewares\Authorize::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tier
    |--------------------------------------------------------------------------
    |
    | In k8s, we can have multiple tiers of the same application. Eg: admin, api, etc.
    | We can use different collectors and sets for different tiers.
    | Admin only returns Horizon metrics, API only returns PHP-FPM metrics.
    |
    */
    
    'tier' => env('PROMETHEUS_EXPORTER_TIER', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Tier list
    |--------------------------------------------------------------------------
    |
    | This option controls the list of tiers and their collectors and sets.
    |
    */
    
    'tiers' => [
        'default' => [
            'collectors' => [
                \Vntrungld\PrometheusExporter\Collectors\TestCollector::class,
            ],
            'sets' => [],
        ],
    ],
];
