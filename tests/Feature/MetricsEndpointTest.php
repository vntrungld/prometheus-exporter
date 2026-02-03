<?php

namespace Vntrungld\PrometheusExporter\Tests\Feature;

use Vntrungld\PrometheusExporter\Tests\TestCase;

class MetricsEndpointTest extends TestCase
{
    public function test_metrics_endpoint_returns_success(): void
    {
        $response = $this->get('/metrics');

        $response->assertStatus(200);
    }

    public function test_metrics_endpoint_returns_prometheus_content_type(): void
    {
        $response = $this->get('/metrics');

        $this->assertStringStartsWith('text/plain; version=0.0.4', $response->headers->get('Content-Type'));
    }

    public function test_metrics_endpoint_requires_token_when_configured(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'test-token');

        $response = $this->get('/metrics');

        $response->assertStatus(401);
    }

    public function test_metrics_endpoint_works_with_valid_token(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'test-token');

        $response = $this->get('/metrics?token=test-token');

        $response->assertStatus(200);
    }

    public function test_metrics_endpoint_rejects_invalid_token(): void
    {
        $this->app['config']->set('prometheus-exporter.token', 'test-token');

        $response = $this->get('/metrics?token=wrong-token');

        $response->assertStatus(401);
    }

    public function test_config_path_is_configurable(): void
    {
        $this->assertEquals('metrics', config('prometheus-exporter.path'));

        $this->app['config']->set('prometheus-exporter.path', 'custom-metrics');

        $this->assertEquals('custom-metrics', config('prometheus-exporter.path'));
    }
}
