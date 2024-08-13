<?php

namespace Vntrungld\PrometheusExporter\Collector\Horizon;

use Laravel\Horizon\Contracts\JobRepository;
use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class RecentJobsCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('horizon_recent_jobs')
            ->help('The number of recent jobs')
            ->value(app(JobRepository::class)->countRecent());
    }
}
