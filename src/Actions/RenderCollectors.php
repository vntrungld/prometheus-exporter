<?php

namespace Vntrungld\PrometheusExporter\Actions;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class RenderCollectors
{
    /**
     * @var CollectorRegistry
     */
    protected CollectorRegistry $registry;

    /**
     * @var RenderTextFormat
     */
    protected RenderTextFormat $renderer;

    /**
     * RenderCollectors constructor.
     *
     * @param CollectorRegistry $registry
     * @param RenderTextFormat $renderer
     */
    public function __construct(CollectorRegistry $registry, RenderTextFormat $renderer)
    {
        $this->registry = $registry;
        $this->renderer = $renderer;
    }

    /**
     * Render the collectors
     *
     * @param $collectors
     * @return string
     * @throws \Throwable
     */
    public function __invoke($collectors): string
    {
        foreach ($collectors as $collector) {
            $collector->register($this->registry);
        }

        return $this->renderer->render($this->registry->getMetricFamilySamples());
    }

    /**
     * Wipe the storage
     */
    public function __destruct()
    {
        $this->registry->wipeStorage();
    }
}
