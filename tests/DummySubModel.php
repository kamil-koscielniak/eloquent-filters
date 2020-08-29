<?php


namespace KamilKoscielniak\EloquentFilters\Tests;


use Illuminate\Database\Eloquent\Model;
use KamilKoscielniak\EloquentFilters\Filters\PartialFilter;
use KamilKoscielniak\EloquentFilters\Traits\Filterable;

class DummySubModel extends Model
{
    use Filterable;

    protected $table = 'categories';
    protected $fillable = ['name'];

    public static array $filters = [
        'name' => PartialFilter::class,
    ];
}
