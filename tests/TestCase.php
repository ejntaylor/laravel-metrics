<?php

namespace Ejntaylor\LaravelMetrics\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Ejntaylor\LaravelMetrics\LaravelMetricsServiceProvider;
use Illuminate\Support\Facades\Schema;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Ejntaylor\\LaravelMetrics\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelMetricsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
//        config()->set('database.default', 'testing');

//        Schema::dropDatabaseIfExists('laravel_metrics');
        Schema::dropAllTables();

        $migration = include __DIR__.'/../database/migrations/create_metrics_table.php.stub';
        $migration->up();

//        dd('asd');

    }
}
