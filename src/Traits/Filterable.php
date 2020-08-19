<?php

namespace KamilKoscielniak\EloquentFilters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Contracts\IFilter;

trait Filterable
{
    /**
     * @param Builder $query
     * @param Request $request
     *
     * @return Builder
     */
    public static function scopeFilter(Builder $query, Request $request)
    {
        foreach (static::$filters as $attr_name => $filterType) {
            try {
                /** @var IFilter $filter */
                $filter = new $filterType($query, $request);
            } catch (\Exception $e) {
                continue;
            }

            $filter->filter($attr_name);
            $query = $filter->query;
        }

        return $query;
    }
}
