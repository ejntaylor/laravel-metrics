<?php

namespace Tests\Unit\Metrics;

use App\Metrics\Metric;
use App\Models\AggregatedMetric;
use App\Models\Platform;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class TestMetric extends Metric
{
    use RefreshDatabase;

    public $saveDate = null;

    public function key(): string
    {
        return 'test_metric';
    }

    public function title(): string
    {
        return 'test metric';
    }

    public function query(): Builder
    {
        return User::query();
    }

    public function save(): Collection
    {
        if (! $this->saveDate) {
            return parent::save();
        }

        return Platform::all()->map(function ($platform) {
            $params = [
                'key' => $this->key(),
                'value' => $this->countFromQuery(),
                'parent_id' => $platform->id,
            ];

            $result = AggregatedMetric::create($params);

            if ($this->saveDate) {
                $result->created_at = $this->saveDate;
                $result->updated_at = $this->saveDate;

                $result->save();
                $result->refresh();

                $this->saveDate = null;
            }

            return $result;
        });
    }

    public function saveForDate(Carbon $date): AggregatedMetric
    {
        $this->saveDate = $date;

        return $this->save();
    }
}
