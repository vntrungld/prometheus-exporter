<?php

namespace Vntrungld\PrometheusExporter\Collector\PhpFpm;

use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class StartSinceCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addCounter('fpm_start_since')
            ->help('The number of seconds since FPM has started.')
            ->value($status['start-since']);
    }
}
