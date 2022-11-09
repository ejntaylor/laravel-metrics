<?php

namespace Ejntaylor\LaravelMetrics;

use Carbon\Carbon;
use Ejntaylor\LaravelMetrics\Models\AggregatedMetric;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Metric
{
    public string $dateColumnToFilterBy = 'created_at';

    abstract public function key(): string;

    abstract public function title(): string;

    abstract public function query(): Builder;

    /**
     * @return Collection<AggregatedMetric>
     */
    public function save(): Collection
    {
        $parentModel = config('metrics.parent');

        if (empty($parentModel)) {
            $params = [
                'key' => $this->key(),
                'value' => $this->countFromQuery(),
                'total' => $this->countFromQuery(filterCountByDateColumn: false),
                'platform_id' => null,
            ];

            return collect(AggregatedMetric::create($params));
        }

        return app($parentModel)::all()->map(function ($parent) {
            $params = [
                'key' => $this->key(),
                'value' => $this->countFromQuery(),
                'total' => $this->countFromQuery(filterCountByDateColumn: false),
                'platform_id' => $parent->id,
            ];

            return AggregatedMetric::create($params);
        });
    }

    public function countFromQuery(?Model $parentModel = null, bool $filterCountByDateColumn = true): int
    {
        $this->filterQueryByPlatform($parentModel);

        return $this->query()
            ->when($filterCountByDateColumn && $this->dateColumnToFilterBy, function ($query) {
                return $query->whereDate($this->dateColumnToFilterBy, Carbon::today());
            })
            ->count();
    }

    public function getHistoricalValueSum(
        Carbon $startDate,
        Carbon $endDate,
        ?Model $parentModel
    ): int {
        $query = AggregatedMetric::query()
            ->with('platform')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('key', $this->key());

        if ($parentModel) {
            $query->whereRelation('platform', 'platform_id', '=', $parentModel->id);
        }

        return $query->sum('value');
    }

    public function getLatestTotal(?Model $parentModel): ?int
    {
        $query = AggregatedMetric::query()
            ->with('platform')
            ->where('key', $this->key())
            ->orderBy('created_at', 'desc');

        if ($parentModel) {
            $query->whereRelation('platform', 'platform_id', '=', $parentModel->id);
        }

        return $query->limit(1)->value('total');
    }

    protected function filterQueryByPlatform(?Model $parentModel = null): Builder
    {
        if (is_null($parentModel)) {
            return $this->query();
        }

        return $this->query()
            ->whereHas('platform', function ($query) use ($parentModel) {
                $query->where('platform_id', '=', $parentModel->id);
            })
            ->orWhereHas('application', function ($query) use ($parentModel) {
                $query->where('application.platform_id', '=', $parentModel->id);
            })
            ->orWhereHas('repository', function ($query) use ($parentModel) {
                $query->where('repository.application.platform_id', '=', $parentModel->id);
            });
    }
}
