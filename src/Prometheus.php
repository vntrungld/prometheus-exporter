<?php

namespace Vntrungld\PrometheusExporter;

use Vntrungld\PrometheusExporter\Actions\RenderCollectors;
use Vntrungld\PrometheusExporter\MetricTypes\Counter;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporter\MetricTypes\Histogram;
use Vntrungld\PrometheusExporter\MetricTypes\Summary;
use Vntrungld\PrometheusExporter\MetricTypes\Type;

class Prometheus
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var array<Type>
     */
    protected array $collectors = [];

    /**
     * Prometheus constructor.
     */
    public function __construct()
    {
        $this->namespace = config('prometheus-exporter.namespace');
    }

    public function addCounter($name): Counter
    {
        $counter = new Counter;

        $this->collectors[] = $counter
            ->namespace($this->namespace)
            ->name($name);

        return $counter;
    }

    public function addGauge($name): Gauge
    {
        $gauge = new Gauge;

        $this->collectors[] = $gauge
            ->namespace($this->namespace)
            ->name($name);

        return $gauge;
    }

    public function addHistogram($name): Histogram
    {
        $histogram = new Histogram;

        $this->collectors[] = $histogram
            ->namespace($this->namespace)
            ->name($name);

        return $histogram;
    }

    public function addSummary($name): Summary
    {
        $summary = new Summary;

        $this->collectors[] = $summary
            ->namespace($this->namespace)
            ->name($name);

        return $summary;
    }

    /**
     * Render the metrics
     *
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        $default_collector_classes = config('prometheus-exporter.collectors');

        foreach ($default_collector_classes as $collector_class) {
            (new $collector_class)->register($this);
        }

        return app(RenderCollectors::class)($this->collectors);
    }
}
