<?php

namespace Vntrungld\PrometheusExporter;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class PrometheusExporterServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (config('prometheus-exporter.enabled')) {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        }

        $this->app->bind(CollectorRegistry::class, function () {
            return new CollectorRegistry(new InMemory(), false);
        });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/prometheus-exporter.php', 'prometheus-exporter');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['prometheus-exporter'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/prometheus-exporter.php' => config_path('prometheus-exporter.php'),
        ], 'prometheus-exporter.config');
    }
}
