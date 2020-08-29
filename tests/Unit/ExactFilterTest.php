<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\DummySubModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class ExactFilterTest extends TestCase
{

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\ExactFilter
     */
    public function test()
    {
        DummyModel::create(['name' => 'Bike', 'is_available' => true]);
        DummyModel::create(['name' => 'Motorbike', 'is_available' => false]);
        DummyModel::create(['name' => 'Scooter', 'is_available' => true]);

        $this->assertCount(3, DummyModel::all());

        $request = new Request();
        $request->merge(['is_available' => true]);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Bike'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Scooter'));
    }

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\ExactFilter
     */
    public function test_relationship()
    {
        $category = DummySubModel::create(['name' => 'Scooters']);

        DummyModel::create(['name' => 'Bike', 'is_available' => true]);
        DummyModel::create(['name' => 'Motorbike', 'is_available' => false]);
        DummyModel::create(['name' => 'Scooter', 'is_available' => true, 'category_id' => $category->id]);

        $this->assertCount(1, DummySubModel::all());
        $this->assertCount(3, DummyModel::all());

        $request = new Request();
        $request->merge(['category__name' => 'Scooters']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(1, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Scooter'));
    }

}
