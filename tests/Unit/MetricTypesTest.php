<?php

namespace Vntrungld\PrometheusExporter\Tests\Unit;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Vntrungld\PrometheusExporter\MetricTypes\Counter;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporter\MetricTypes\Histogram;
use Vntrungld\PrometheusExporter\MetricTypes\Summary;
use Vntrungld\PrometheusExporter\Tests\TestCase;

class MetricTypesTest extends TestCase
{
    protected CollectorRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = new CollectorRegistry(new InMemory(), false);
    }

    public function test_counter_can_set_namespace(): void
    {
        $counter = new Counter();
        $result = $counter->namespace('test_namespace');

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_set_name(): void
    {
        $counter = new Counter();
        $result = $counter->name('test_name');

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_set_help(): void
    {
        $counter = new Counter();
        $result = $counter->help('Test help text');

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_set_labels(): void
    {
        $counter = new Counter();
        $result = $counter->labels(['label1', 'label2']);

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_set_value(): void
    {
        $counter = new Counter();
        $result = $counter->value(5);

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_set_value_with_labels(): void
    {
        $counter = new Counter();
        $result = $counter->value(5, ['label_value']);

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_counter_can_register(): void
    {
        $counter = (new Counter())
            ->namespace('test')
            ->name('test_counter')
            ->help('Test counter')
            ->labels([])
            ->value(1);

        $result = $counter->register($this->registry);

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_gauge_can_register(): void
    {
        $gauge = (new Gauge())
            ->namespace('test')
            ->name('test_gauge')
            ->help('Test gauge')
            ->labels([])
            ->value(42);

        $result = $gauge->register($this->registry);

        $this->assertInstanceOf(Gauge::class, $result);
    }

    public function test_histogram_can_register(): void
    {
        $histogram = (new Histogram())
            ->namespace('test')
            ->name('test_histogram')
            ->help('Test histogram')
            ->labels([])
            ->value(0.5);

        $result = $histogram->register($this->registry);

        $this->assertInstanceOf(Histogram::class, $result);
    }

    public function test_summary_can_register(): void
    {
        $summary = (new Summary())
            ->namespace('test')
            ->name('test_summary')
            ->help('Test summary')
            ->labels([])
            ->value(0.5);

        $result = $summary->register($this->registry);

        $this->assertInstanceOf(Summary::class, $result);
    }

    public function test_counter_can_register_with_labels_and_values(): void
    {
        $counter = (new Counter())
            ->namespace('test')
            ->name('labeled_counter')
            ->help('Test counter with labels')
            ->labels(['method', 'status'])
            ->value(1, ['GET', '200'])
            ->value(2, ['POST', '201']);

        $result = $counter->register($this->registry);

        $this->assertInstanceOf(Counter::class, $result);
    }

    public function test_gauge_can_register_with_labels_and_values(): void
    {
        $gauge = (new Gauge())
            ->namespace('test')
            ->name('labeled_gauge')
            ->help('Test gauge with labels')
            ->labels(['service'])
            ->value(100, ['api'])
            ->value(50, ['worker']);

        $result = $gauge->register($this->registry);

        $this->assertInstanceOf(Gauge::class, $result);
    }

    public function test_values_can_be_set_as_array(): void
    {
        $counter = new Counter();
        $result = $counter->values([[1, []], [2, []]]);

        $this->assertInstanceOf(Counter::class, $result);
    }
}
