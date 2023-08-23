<?php

namespace Tests\Unit\Metrics;

use App\Models\AggregatedMetric;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait CreatesMetricValueTestMethod
{
    protected function metric()
    {
        return (new $this->metricClass);
    }

    protected function storeMetric(Carbon $date): void
    {
        Carbon::setTestNow($date);
        $this->metric()->save();
        Carbon::setTestNow();
    }

    protected function getAggregatedMetric(Carbon $date): Model|null
    {
        return AggregatedMetric::query()->whereDate('created_at', $date)->first();
    }
}
