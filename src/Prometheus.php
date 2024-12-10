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

    /**
     * Add a counter
     *
     * @param $name
     * @return Counter
     */
    public function addCounter($name): Counter
    {
        $counter = new Counter;

        $this->collectors[] = $counter
            ->namespace($this->namespace)
            ->name($name);

        return $counter;
    }

    /**
     * Add a gauge
     *
     * @param $name
     * @return Gauge
     */
    public function addGauge($name): Gauge
    {
        $gauge = new Gauge;

        $this->collectors[] = $gauge
            ->namespace($this->namespace)
            ->name($name);

        return $gauge;
    }

    /**
     * Add a histogram
     *
     * @param $name
     * @return Histogram
     */
    public function addHistogram($name): Histogram
    {
        $histogram = new Histogram;

        $this->collectors[] = $histogram
            ->namespace($this->namespace)
            ->name($name);

        return $histogram;
    }

    /**
     * Add a summary
     *
     * @param $name
     * @return Summary
     */
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
        $tier_name = config('prometheus-exporter.tier');
        $tier_config = config('prometheus-exporter.tiers.' . $tier_name);
        $collector_sets = array_get($tier_config, 'sets', []);
        $collectors = array_get($tier_config, 'collectors', []);

        foreach ($collector_sets as $collector_set) {
            $collectors = array_merge($collectors, (new $collector_set)->collectors());
        }
        
        $collectors = array_unique($collectors);

        foreach ($collectors as $collector) {
            (new $collector)->register($this);
        }

        return app(RenderCollectors::class)($this->collectors);
    }
}
