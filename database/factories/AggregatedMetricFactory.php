<?php

namespace Database\Factories;

use Ejntaylor\LaravelMetrics\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;

class AggregatedMetricFactory extends Factory
{
    public function definition()
    {
        $platform = app()->runningUnitTests()
            ? Platform::factory()->create()
            : Platform::all()->shuffle()->first();

        $value = random_int(1, 100);
        $total = $value + random_int(1, 100);

        return [
            'key' => $this->faker->randomElement(['one', 'two', 'three', 'four']),
            'value' => $value,
            'total' => $total,
            'platform_id' => $platform->id,
        ];
    }
}
