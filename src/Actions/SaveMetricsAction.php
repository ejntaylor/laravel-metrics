<?php

namespace Ejntaylor\LaravelMetrics\Actions;

use Ejntaylor\LaravelMetrics\LaravelMetrics;

class SaveMetricsAction
{
    public function __construct(protected LaravelMetrics $laravelMetrics)
    {
    }

    public function execute()
    {
        foreach ($this->laravelMetrics->getMetrics() as $metricClass) {
            $metric = new $metricClass();
            $metric->save();
        }
    }
}
