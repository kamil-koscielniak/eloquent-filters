<?php

namespace KamilKoscielniak\EloquentFilters;

use KamilKoscielniak\EloquentFilters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

abstract class FilterableModel extends Model
{
    use Filterable;

    public static array $filters = [];
}
