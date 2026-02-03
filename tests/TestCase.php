<?php

namespace Vntrungld\PrometheusExporter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Vntrungld\PrometheusExporter\PrometheusExporterServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PrometheusExporterServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Prometheus' => \Vntrungld\PrometheusExporter\Facades\Prometheus::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('prometheus-exporter.enabled', true);
        $app['config']->set('prometheus-exporter.namespace', 'test');
        $app['config']->set('prometheus-exporter.path', 'metrics');
        $app['config']->set('prometheus-exporter.token', null);
        $app['config']->set('prometheus-exporter.tier', 'default');
        $app['config']->set('prometheus-exporter.tiers', [
            'default' => [
                'collectors' => [],
                'sets' => [],
            ],
        ]);
    }
}
