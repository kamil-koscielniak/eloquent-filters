<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

use KamilKoscielniak\EloquentFilters\Contracts\IFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    public Builder $query;
    protected Request $request;

    /**
     * Filter constructor.
     *
     * @param Builder $query
     * @param Request $request
     */
    public function __construct(Builder $query, Request $request)
    {
        $this->query = $query;
        $this->request = $request;
    }

    /**
     * @param string $attr_name
     * @param string $operator
     *
     * @param string $value
     *
     * @return IFilter
     */
    protected function relationFilter(string $attr_name, string $operator, string $value): IFilter
    {
        $attr_array = explode('___', $attr_name);
        $relation = $attr_array[0];
        $attr_name = $attr_array[1];

        $this->query->whereHas($relation, function (Builder $q) use ($attr_name, $operator, $value) {
            $q->where($attr_name, $operator, $value);
        });

        return $this;
    }

    /**
     * @param string $attr_name
     *
     * @return int|mixed
     */
    protected function getIncludeExcludeValue(string $attr_name)
    {
        return $this->request->input($attr_name . '_inc') ?? 1;
    }

    /**
     * @param string $attr_name
     *
     * @return bool
     */
    protected function isRelationshipFilter(string $attr_name)
    {
        return count(explode('___', $attr_name)) === 2;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function isExcludeOptionOn(string $value): bool
    {
        $arr = explode(config('filters.separator'), $value);
        $v = $arr[count($arr)-1];

        if (is_bool($v)) {
            return $v;
        }

        return false;
    }
}
