<?php

return [
    'namespace' => 'laravel',
    'path' => 'metrics',
    'collectors' => [
        \Vntrungld\PrometheusExporter\Collectors\TestCollector::class,
    ],
];
