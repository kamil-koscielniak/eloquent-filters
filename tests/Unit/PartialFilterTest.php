<?php


namespace KamilKoscielniak\EloquentFilters\Tests\Unit;


use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Tests\DummyModel;
use KamilKoscielniak\EloquentFilters\Tests\TestCase;

class PartialFilterTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepare_data();
    }

    /**
     * @covers \KamilKoscielniak\EloquentFilters\Filters\PartialFilter
     */
    public function test()
    {
        $this->assertDatabaseCount('products', 3);

        $request = new Request();
        $request->merge(['name' => 'bike']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(2, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Bike'));
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Motorbike'));
    }

    public function test_exclusion()
    {
        $this->assertDatabaseCount('products', 3);

        $request = new Request();
        $request->merge(['name' => 'bike|e']);
        $results = DummyModel::filter($request)->get();

        $this->assertCount(1, $results);
        $this->assertNotFalse($results->search(fn($item) => $item->name === 'Scooter'));
    }

    private function prepare_data()
    {
        DummyModel::create(['name' => 'Bike', 'is_available' => true]);
        DummyModel::create(['name' => 'Motorbike', 'is_available' => false]);
        DummyModel::create(['name' => 'Scooter', 'is_available' => true]);
    }

}
