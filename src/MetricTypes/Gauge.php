<?php

namespace Vntrungld\PrometheusExporter\MetricTypes;

use Prometheus\CollectorRegistry;
use Prometheus\Gauge as PrometheusGauge;

class Gauge extends Type
{
    /**
     * @inheritDoc
     */
    public function register(CollectorRegistry $registry): Type
    {
        $gauge = $registry->getOrRegisterGauge(
            $this->namespace,
            $this->name,
            $this->help ?? '',
            $this->labels
        );

        $this->handleValues($gauge);

        return $this;
    }

    /**
     * Handle the values for the gauge
     *
     * @param PrometheusGauge $gauge
     * @return void
     */
    protected function handleValues(PrometheusGauge $gauge)
    {
        foreach ($this->values as $value) {
            if (is_array($value)) {
                [$value, $labels] = $value;
                $gauge->set($value, $labels);
            } else {
                $gauge->set($value);
            }
        }
    }
}
