<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Ejntaylor\LaravelMetrics\LaravelMetrics;
use Ejntaylor\LaravelMetrics\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Snapshots\MatchesSnapshots;

class LaravelMetricsTest extends TestCase
{
    use RefreshDatabase;
    use MatchesSnapshots;

    /** @test */
    public function it_generates_an_empty_default_report()
    {
        /** @var LaravelMetrics $laravelMetrics */
        $laravelMetrics = app(LaravelMetrics::class);

        $this->assertMatchesSnapshot($laravelMetrics->getReportPlatformsFormatted());
    }
}
