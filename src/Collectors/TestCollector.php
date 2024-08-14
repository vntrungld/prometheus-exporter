<?php

namespace Vntrungld\PrometheusExporter\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class TestCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('test_metric')
            ->help('This is a test metric')
            ->labels(['test_label'])
            ->value(100, ['test_value']);
    }
}
