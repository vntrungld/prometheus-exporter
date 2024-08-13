<?php

namespace Vntrungld\PrometheusExporter\MetricTypes;

use Prometheus\CollectorRegistry;
use Prometheus\Histogram as PrometheusHistogram;

class Histogram extends Type
{
    /**
     * @inheritDoc
     */
    public function register(CollectorRegistry $registry): Type
    {
        $histogram = $registry->getOrRegisterHistogram(
            $this->namespace,
            $this->name,
            $this->help ?? '',
            $this->labels,
        );

        $this->handleValues($histogram);

        return $this;
    }

    /**
     * Handle the values for the histogram
     *
     * @param PrometheusHistogram $histogram
     * @return void
     */
    protected function handleValues(PrometheusHistogram $histogram)
    {
        foreach ($this->values as $value) {
            if (is_array($value)) {
                [$value, $labels] = $value;
                $histogram->observe($value, $labels);
            } else {
                $histogram->observe($value);
            }
        }
    }
}
