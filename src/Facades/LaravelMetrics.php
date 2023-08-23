<?php

namespace Ejntaylor\LaravelMetrics\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ejntaylor\LaravelMetrics\LaravelMetrics
 */
class LaravelMetrics extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ejntaylor\LaravelMetrics\LaravelMetrics::class;
    }
}
