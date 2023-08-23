<?php

namespace Ejntaylor\LaravelMetrics;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Ejntaylor\LaravelMetrics\Commands\LaravelMetricsCommand;

class LaravelMetricsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-metrics')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-metrics_table')
            ->hasCommand(LaravelMetricsCommand::class);
    }
}
