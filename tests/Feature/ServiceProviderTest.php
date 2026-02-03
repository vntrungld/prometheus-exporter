<?php

namespace Vntrungld\PrometheusExporter\Tests\Feature;

use Prometheus\CollectorRegistry;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporter\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_registers_config(): void
    {
        $this->assertNotNull(config('prometheus-exporter'));
    }

    public function test_service_provider_binds_collector_registry(): void
    {
        $registry = $this->app->make(CollectorRegistry::class);

        $this->assertInstanceOf(CollectorRegistry::class, $registry);
    }

    public function test_prometheus_can_be_instantiated(): void
    {
        $prometheus = new Prometheus();

        $this->assertInstanceOf(Prometheus::class, $prometheus);
    }

    public function test_routes_are_registered_when_enabled(): void
    {
        $this->app['config']->set('prometheus-exporter.enabled', true);

        $routes = $this->app['router']->getRoutes();
        $metricsRoute = $routes->getByAction('Vntrungld\PrometheusExporter\Controllers\PrometheusExporterController@index');

        $this->assertNotNull($metricsRoute);
    }

    public function test_config_has_expected_keys(): void
    {
        $config = config('prometheus-exporter');

        $this->assertArrayHasKey('enabled', $config);
        $this->assertArrayHasKey('namespace', $config);
        $this->assertArrayHasKey('path', $config);
        $this->assertArrayHasKey('token', $config);
        $this->assertArrayHasKey('middleware', $config);
        $this->assertArrayHasKey('tier', $config);
        $this->assertArrayHasKey('tiers', $config);
    }
}
