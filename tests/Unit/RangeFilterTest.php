<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class RangeFilterTest extends TestCase
{

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\RangeFilter
     */
    public function test()
    {
        DummyModel::create(['name' => 'Prod#1', 'price' => 10]);
        DummyModel::create(['name' => 'Prod#2', 'price' => 20]);
        DummyModel::create(['name' => 'Prod#3', 'price' => 22]);
        DummyModel::create(['name' => 'Prod#4', 'price' => 55]);

        $this->assertDatabaseCount('products', 4);

        $request = new Request();
        $request->merge(['price' => '15/40']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Prod#2'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Prod#3'));
    }

}
