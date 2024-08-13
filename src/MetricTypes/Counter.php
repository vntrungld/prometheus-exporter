<?php

namespace Vntrungld\PrometheusExporter\MetricTypes;

use Prometheus\CollectorRegistry;
use Prometheus\Counter as PrometheusCounter;

class Counter extends Type
{
    /**
     * @inheritDoc
     */
    public function register(CollectorRegistry $registry): Type
    {
        $counter = $registry->getOrRegisterCounter(
            $this->namespace,
            $this->name,
            $this->help ?? '',
            $this->labels
        );

        $this->handleValues($counter);

        return $this;
    }

    /**
     * Handle the values for the counter
     *
     * @param PrometheusCounter $counter
     * @return void
     */
    protected function handleValues(PrometheusCounter $counter)
    {
        foreach ($this->values as $value) {
            if (is_array($value)) {
                [$value, $labels] = $value;
                $counter->incBy($value, $labels);
            } else {
                $counter->incBy($value);
            }
        }
    }
}
