<?php

namespace KamilKoscielniak\EloquentFilters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use KamilKoscielniak\EloquentFilters\Filters\AbstractFilter;

trait Filterable
{
    /**
     * @param Builder $query
     * @param Request $request
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, Request $request)
    {
        if (! property_exists(self::class, 'filters')) {
            return $query;
        }

        foreach (static::$filters as $attr_name => $filterType) {
            try {
                /** @var AbstractFilter $filter */
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
