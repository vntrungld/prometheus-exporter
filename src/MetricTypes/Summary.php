<?php

namespace Vntrungld\PrometheusExporter\MetricTypes;

use Prometheus\CollectorRegistry;
use Prometheus\Summary as PrometheusSummary;

class Summary extends Type
{
    /**
     * @inheritDoc
     */
    public function register(CollectorRegistry $registry): Type
    {
        $summary = $registry->getOrRegisterSummary(
            $this->namespace,
            $this->name,
            $this->help ?? '',
            $this->labels
        );

        $this->handleValues($summary);

        return $this;
    }

    protected function handleValues(PrometheusSummary $summary)
    {
        foreach ($this->values as $value) {
            if (is_array($value)) {
                [$value, $labels] = $value;
                $summary->observe($value, $labels);
            } else {
                $summary->observe($value);
            }
        }
    }
}
