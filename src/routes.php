<?php

Route::get(config('prometheus-exporter.path'), 'Vntrungld\PrometheusExporter\Controllers\PrometheusExporterController@index');
