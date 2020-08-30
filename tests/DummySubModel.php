<?php


namespace KamilKoscielniak\EloquentFilters\Tests;


use Illuminate\Database\Eloquent\Model;
use KamilKoscielniak\EloquentFilters\Filters\PartialFilter;
use KamilKoscielniak\EloquentFilters\Filters\RangeFilter;
use KamilKoscielniak\EloquentFilters\Traits\Filterable;

class DummySubModel extends Model
{
    use Filterable;

    protected $table = 'categories';
    protected $fillable = ['name'];

    public static array $filters = [
        'name' => PartialFilter::class,
        'products__price' => RangeFilter::class
    ];

    public function products()
    {
        return $this->hasMany(DummyModel::class, 'category_id', 'id');
    }
}
