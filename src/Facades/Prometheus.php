<?php

namespace Vntrungld\PrometheusExporter\Facades;

use Illuminate\Support\Facades\Facade;

class Prometheus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'prometheus-exporter';
    }
}
