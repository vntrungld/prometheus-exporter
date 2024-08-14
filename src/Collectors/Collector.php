<?php

namespace Vntrungld\PrometheusExporter\Collectors;

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
