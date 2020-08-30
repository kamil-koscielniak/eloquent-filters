<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\DummySubModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class RangeFilterTest extends TestCase
{

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\RangeFilter
     */
    public function test_with_inclusion_mode()
    {
        $this->prepare_data();
        $this->assertCount(4, DummyModel::all());

        $request = new Request();
        $request->merge(['price' => '20/40']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Prod#2'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Prod#3'));
    }

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\RangeFilter
     */
    public function test_with_exclusion_mode()
    {
        $this->prepare_data();
        $this->assertCount(4, DummyModel::all());

        $request = new Request();
        $request->merge(['price' => '20|e/40']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(1, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Prod#3'));
    }

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\RangeFilter
     */
    public function test_relationship_filter()
    {
        $tools = DummySubModel::create(['name' => 'Tools']);
        $bikes = DummySubModel::create(['name' => 'Bikes']);

        DummyModel::create(['name' => 'Prod#1', 'price' => 10, 'category_id' => $tools->id]);
        DummyModel::create(['name' => 'Prod#2', 'price' => 20, 'category_id' => $tools->id]);
        DummyModel::create(['name' => 'Prod#3', 'price' => 22, 'category_id' => $bikes->id]);
        DummyModel::create(['name' => 'Prod#4', 'price' => 55, 'category_id' => $bikes->id]);

        $request = new Request();
        $request->merge(['products__price' => '10|e/20']);
        $results = DummySubModel::filter($request)->get();

        $this->assertCount(1, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === $tools->name));
    }

    private function prepare_data()
    {
        DummyModel::create(['name' => 'Prod#1', 'price' => 10]);
        DummyModel::create(['name' => 'Prod#2', 'price' => 20]);
        DummyModel::create(['name' => 'Prod#3', 'price' => 22]);
        DummyModel::create(['name' => 'Prod#4', 'price' => 55]);
    }


}
