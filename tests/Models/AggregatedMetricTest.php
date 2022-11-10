<?php

namespace Ejntaylor\LaravelMetrics\Tests\Models;

use Ejntaylor\LaravelMetrics\Models\AggregatedMetric;
use Ejntaylor\LaravelMetrics\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AggregatedMetricTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_model()
    {
        AggregatedMetric::factory()->count(2)->create([
            'key' => 'test-key',
            'value' => 123,
        ]);

        $this->assertCount(2, AggregatedMetric::all());
    }
}
