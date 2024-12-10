<?php

namespace Vntrungld\PrometheusExporter\Collectors;

interface CollectorSet
{
    /**
     * Get the collectors
     * 
     * @return array
     */
    public function collectors(): array;
}