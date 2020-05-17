<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class OneToOneFilterTest extends TestCase
{

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\OneToOneFilter
     */
    public function test()
    {
        DummyModel::create(['name' => 'Bike', 'is_available' => true]);
        DummyModel::create(['name' => 'Motorbike', 'is_available' => false]);
        DummyModel::create(['name' => 'Scooter', 'is_available' => true]);

        $this->assertDatabaseCount('products', 3);

        $request = new Request();
        $request->merge(['is_available' => true]);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Bike'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Scooter'));
    }

}
