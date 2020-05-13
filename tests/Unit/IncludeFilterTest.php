<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class IncludeFilterTest extends TestCase
{

    public function test()
    {
        DummyModel::create(['name' => 'Bike']);
        DummyModel::create(['name' => 'Motorbike']);
        DummyModel::create(['name' => 'Scooter']);

        $this->assertDatabaseCount('products', 3);

        $request = new Request();
        $request->merge(['name' => 'bike']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Bike'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Motorbike'));
    }

}
