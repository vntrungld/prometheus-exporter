<?php

namespace Vntrungld\PrometheusExporter\Collector\PhpFpm;

use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class MaxListenQueueCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addCounter('fpm_max_listen_queue')
            ->help('The maximum number of requests in the queue of pending connections since FPM has started.')
            ->value($status['max-listen-queue']);
    }
}
