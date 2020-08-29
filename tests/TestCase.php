<?php


namespace KamilKoscielniak\EloquentFilters\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use KamilKoscielniak\EloquentFilters\EloquentFiltersProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
        Artisan::call('vendor:publish --tag=config');
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
        $schema_builder = $this->app['db']->connection()->getSchemaBuilder();

        $schema_builder->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->string('name')->nullable();
            $table->float('price', 5, 2)->nullable();
            $table->boolean('is_available')->nullable();
            $table->timestamps();
        });

        $schema_builder->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

}
