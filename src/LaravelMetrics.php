<?php

namespace Ejntaylor\LaravelMetrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LaravelMetrics
{
    protected array $metrics;

    protected int $dayGrouping = 7;

    public const FORMAT_DEFAULT = 'default';

    public const FORMAT_GQL = 'graphQL';

    public function __construct()
    {
        $this->setMetrics(config('metrics.metrics'));
    }

    public function getDayGrouping(): int
    {
        return $this->dayGrouping;
    }

    public function setDayGrouping(int $dayGrouping): self
    {
        $this->dayGrouping = $dayGrouping;

        return $this;
    }

    public function getMetrics(): array
    {
        return $this->metrics;
    }

    public function setMetrics(array $array): self
    {
        $this->metrics = $array;

        return $this;
    }

    public function reportRows(
        $format = self::FORMAT_DEFAULT,
        ?Model $platform = null
    ): array {
        $rows = [];

        /** @var Metric $metric */
        foreach ($this->metrics as $metric) {
            $endOfToday = Carbon::today()->endOfDay();

            $valuePrevious = $metric->getHistoricalValueSum(
                $endOfToday->copy()->subDays($this->dayGrouping * 2),
                $endOfToday->copy()->subDays($this->dayGrouping),
                $platform
            );

            $value = $metric->getHistoricalValueSum(
                $endOfToday->copy()->subDays($this->dayGrouping),
                $endOfToday,
                $platform
            );

            $total = $metric->getLatestTotal($platform);

            $rows[] = match ($format) {
                self::FORMAT_GQL => [
                    'key' => $metric->key(),
                    'title' => $metric->title(),
                    'previous' => $valuePrevious,
                    'value' => $value,
                    'total' => $total,
                    'difference' => static::getDifference($valuePrevious, $value),
                ],
                default => [
                    $metric->title(),
                    $valuePrevious,
                    $value,
                    sprintf('%.0f%%', static::getDifference($valuePrevious, $value) * 100),
                ],
            };
        }

        return $rows;
    }

    public function getReportPlatform(
        Model $platform,
        $format = self::FORMAT_DEFAULT,
    ): array {
        return
            [
                'platform' => $platform->name,
                'metrics' => $this->reportRows($format, $platform),
            ];
    }

    public function getReportPlatforms(
        ?Collection $platforms = null,
        $format = self::FORMAT_DEFAULT,
    ): array {
        $platforms = $platforms ?? Platform::all();

        return $platforms->flatMap(
            fn($platform) => [$this->getReportPlatform($platform, $format)]
        )->toArray();
    }

    public function getReportTotal(
        $format = self::FORMAT_DEFAULT,
    ): array {
        return ['metrics' => $this->reportRows($format)];
    }

    public function getReportPlatformsFormatted(
        ?Collection $platforms = null,
        $format = self::FORMAT_DEFAULT,
    ): string {
        $platforms = $platforms ?? Platform::all();

        return json_encode($this->getReportPlatforms($platforms, $format), JSON_THROW_ON_ERROR);
    }

    public static function getDifference($from, $to): float
    {
        if ($from === 0) {
            return 0;
        }

        return $to / $from;
    }

}
