<?php


namespace KamilKoscielniak\EloquentFilters\Tests;

use Illuminate\Database\Schema\Blueprint;
use KamilKoscielniak\EloquentFilters\EloquentFiltersProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            EloquentFiltersProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('price', 5, 2)->nullable();
            $table->boolean('is_available')->nullable();
            $table->timestamps();
        });
    }

}
