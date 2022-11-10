<?php

namespace Ejntaylor\LaravelMetrics\Tests;

use Ejntaylor\LaravelMetrics\Models\AggregatedMetric;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    public function true_is_true()
    {

        $model = AggregatedMetric::factory()->create([
            'key' => 'test-key',
            'value' => 123,
        ]);

        $this->assertTrue(true);
    }
}
