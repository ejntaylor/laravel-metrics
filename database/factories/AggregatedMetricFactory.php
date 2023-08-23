<?php

namespace Ejntaylor\LaravelMetrics\Database\Factories;

use Ejntaylor\LaravelMetrics\Models\AggregatedMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

class AggregatedMetricFactory extends Factory
{
    protected $model = AggregatedMetric::class;

    public function definition()
    {
        $value = random_int(1, 100);
        $total = $value + random_int(1, 100);

        return [
            'key' => $this->faker->randomElement(['one', 'two', 'three', 'four']),
            'value' => $value,
            'total' => $total,
            'parent_id' => null,
        ];
    }
}
