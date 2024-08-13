<?php

namespace Vntrungld\PrometheusExporter\Collector\PhpFpm;

use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class TotalProcessesCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addCounter('fpm_total_processes')
            ->help('The number of idle + active processes.')
            ->value($status['total-processes']);
    }
}
