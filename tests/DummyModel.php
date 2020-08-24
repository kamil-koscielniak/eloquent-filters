<?php


namespace KamilKoscielniak\EloquentFilters\Tests;


use Illuminate\Database\Eloquent\Model;
use KamilKoscielniak\EloquentFilters\Filters\PartialFilter;
use KamilKoscielniak\EloquentFilters\Filters\ExactFilter;
use KamilKoscielniak\EloquentFilters\Filters\RangeFilter;
use KamilKoscielniak\EloquentFilters\Traits\Filterable;

class DummyModel extends Model
{
    use Filterable;

    protected $table = 'products';
    protected $fillable = ['category_id', 'name', 'price', 'is_available'];

    public static array $filters = [
        'name' => PartialFilter::class,
        'price' => RangeFilter::class,
        'is_available' => ExactFilter::class,
        'category__name' => PartialFilter::class,
    ];

    public function category()
    {
        return $this->belongsTo(DummySubModel::class);
    }
}
