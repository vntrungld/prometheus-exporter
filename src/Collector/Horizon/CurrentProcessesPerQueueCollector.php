<?php

namespace Vntrungld\PrometheusExporter\Collector\Horizon;

use Laravel\Horizon\Contracts\WorkloadRepository;
use Vntrungld\PrometheusExporter\Collector\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class CurrentProcessesPerQueueCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $gauge = $prometheus->addGauge('horizon_current_processes')
            ->help('Current processes of all queues')
            ->labels(['queue']);

        collect(app(WorkloadRepository::class)->get())
            ->sortBy('name')
            ->values()
            ->each(function (array $workload) use ($gauge) {
                $gauge->value($workload['processes'], [$workload['name']]);
            });
    }
}
