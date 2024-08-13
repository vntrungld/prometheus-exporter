<?php

namespace Vntrungld\PrometheusExporter\Collector;

use Vntrungld\PrometheusExporter\Prometheus;

interface Collector
{
    /**
     * Register the collector.
     *
     * @param Prometheus $prometheus
     * @return void
     */
    public function register(Prometheus $prometheus): void;
}
