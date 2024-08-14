<?php

namespace Vntrungld\PrometheusExporter\MetricTypes;

use Illuminate\Support\Arr;
use Prometheus\Collector;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\RenderTextFormat;

abstract class Type
{
    /**
     * @var string
     */
    protected string $namespace;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $help;

    /**
     * @var array
     */
    protected array $labels = [];

    /**
     * @var array
     */
    protected array $values = [];

    /**
     * Set the namespace for the metric
     *
     * @param $namespace
     * @return $this
     */
    public function namespace($namespace): Type
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Set the name of the metric
     *
     * @param $name
     * @return $this
     */
    public function name($name): Type
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the help for the metric
     *
     * @param $help
     * @return $this
     */
    public function help($help): Type
    {
        $this->help = $help;
        return $this;
    }

    public function value($value, $labels = []): Type
    {
        $this->values[] = [$value, $labels];
        return $this;
    }

    /**
     * Set the values for the metric
     *
     * @param array $values
     * @return $this
     */
    public function values(array $values): Type
    {
        $this->values = $values;
        return $this;
    }

    /**
     * Set the labels for the metric
     *
     * @param array $labels
     * @return $this
     */
    public function labels(array $labels): Type
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * Register the metric with the registry
     *
     * @param CollectorRegistry $registry
     * @return Type
     * @throws MetricsRegistrationException
     */
    public abstract function register(CollectorRegistry $registry): Type;
}
