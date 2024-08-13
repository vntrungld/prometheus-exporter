<?php

namespace Vntrungld\PrometheusExporter\Collector\Horizon;

use Laravel\Horizon\Contracts\JobRepository;
use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class FailedJobsPerHourCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('horizon_failed_jobs_per_hour')
            ->help('The number of recently failed jobs')
            ->value(app(JobRepository::class)->countRecentlyFailed());
    }
}
