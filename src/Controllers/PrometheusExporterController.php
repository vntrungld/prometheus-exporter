<?php

namespace Vntrungld\PrometheusExporter\Controllers;


use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Laravel\Horizon\Contracts\WorkloadRepository;
use Prometheus\RenderTextFormat;
use Vntrungld\PrometheusExporter\Prometheus;

class PrometheusExporterController
{
    /**
     * Display a metrics
     *
     * @param Prometheus $prometheus
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Prometheus $prometheus)
    {
        return response(
            $prometheus->render(),
        )->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
