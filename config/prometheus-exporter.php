<?php

return [
    'namespace' => 'laravel',
    'path' => 'metrics',
    'collectors' => [
        // Horizon
        \Vntrungld\PrometheusExporter\Collector\Horizon\CurrentMasterSupervisorCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\CurrentProcessesPerQueueCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\CurrentWorkloadCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\FailedJobsPerHourCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\HorizonStatusCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\JobsPerMinuteCollector::class,
        \Vntrungld\PrometheusExporter\Collector\Horizon\RecentJobsCollector::class,

        // PHP-FPM
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\AcceptedConnectionsCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\ActiveProcessesCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\IdleProcessesCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\ListenQueueCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\ListenQueueLengthCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\MaxActiveProcessesCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\MaxChildrenReachedCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\MaxListenQueueCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\SlowRequestsCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\StartSinceCollector::class,
        \Vntrungld\PrometheusExporter\Collector\PhpFpm\TotalProcessesCollector::class,
    ],
];
