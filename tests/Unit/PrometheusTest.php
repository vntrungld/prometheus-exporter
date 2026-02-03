<?php

namespace Vntrungld\PrometheusExporter\Tests\Unit;

use Vntrungld\PrometheusExporter\MetricTypes\Counter;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporter\MetricTypes\Histogram;
use Vntrungld\PrometheusExporter\MetricTypes\Summary;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporter\Tests\TestCase;

class PrometheusTest extends TestCase
{
    protected Prometheus $prometheus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prometheus = new Prometheus();
    }

    public function test_can_add_counter(): void
    {
        $counter = $this->prometheus->addCounter('test_counter');

        $this->assertInstanceOf(Counter::class, $counter);
    }

    public function test_can_add_gauge(): void
    {
        $gauge = $this->prometheus->addGauge('test_gauge');

        $this->assertInstanceOf(Gauge::class, $gauge);
    }

    public function test_can_add_histogram(): void
    {
        $histogram = $this->prometheus->addHistogram('test_histogram');

        $this->assertInstanceOf(Histogram::class, $histogram);
    }

    public function test_can_add_summary(): void
    {
        $summary = $this->prometheus->addSummary('test_summary');

        $this->assertInstanceOf(Summary::class, $summary);
    }

    public function test_counter_can_be_chained(): void
    {
        $counter = $this->prometheus->addCounter('test_counter')
            ->help('Test help')
            ->labels(['label1', 'label2'])
            ->value(5, ['value1', 'value2']);

        $this->assertInstanceOf(Counter::class, $counter);
    }

    public function test_gauge_can_be_chained(): void
    {
        $gauge = $this->prometheus->addGauge('test_gauge')
            ->help('Test help')
            ->labels(['label1'])
            ->value(10, ['value1']);

        $this->assertInstanceOf(Gauge::class, $gauge);
    }

    public function test_can_get_collectors_for_tier(): void
    {
        $this->app['config']->set('prometheus-exporter.tiers', [
            'test_tier' => [
                'collectors' => ['TestCollector1', 'TestCollector2'],
                'sets' => [],
            ],
        ]);

        $prometheus = new Prometheus();
        $collectors = $prometheus->getCollectors('test_tier');

        $this->assertEquals(['TestCollector1', 'TestCollector2'], $collectors);
    }

    public function test_returns_empty_array_for_nonexistent_tier(): void
    {
        $collectors = $this->prometheus->getCollectors('nonexistent_tier');

        $this->assertEquals([], $collectors);
    }

    public function test_can_get_collector_set_for_tier(): void
    {
        $this->app['config']->set('prometheus-exporter.tiers', [
            'test_tier' => [
                'collectors' => [],
                'sets' => ['TestSet1', 'TestSet2'],
            ],
        ]);

        $prometheus = new Prometheus();
        $sets = $prometheus->getCollectorSet('test_tier');

        $this->assertEquals(['TestSet1', 'TestSet2'], $sets);
    }

    public function test_returns_empty_array_for_nonexistent_collector_set(): void
    {
        $sets = $this->prometheus->getCollectorSet('nonexistent_tier');

        $this->assertEquals([], $sets);
    }
}
