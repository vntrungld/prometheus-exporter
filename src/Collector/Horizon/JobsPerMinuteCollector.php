<?php

namespace Vntrungld\PrometheusExporter\Collector\Horizon;

use Laravel\Horizon\Contracts\MetricsRepository;
use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class JobsPerMinuteCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('horizon_jobs_per_minute')
            ->help('The number of jobs per minute')
            ->value(app(MetricsRepository::class)->jobsProcessedPerMinute());
    }
}
