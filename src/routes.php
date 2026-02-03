<?php

use Illuminate\Support\Facades\Route;
use Vntrungld\PrometheusExporter\Controllers\PrometheusExporterController;

Route::get(config('prometheus-exporter.path'), [PrometheusExporterController::class, 'index'])
    ->middleware(config('prometheus-exporter.middleware'));
