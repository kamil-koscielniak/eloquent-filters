<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

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
     *
     * @return AbstractFilter
     */
    public function filter(string $attr_name): self
    {
        $value = $this->request->input($attr_name);

        if ($value === null) {
            return $this;
        }

        if ($this->isExclusionModeOn($value)) {
            $operator = $this->getNegativeOperator();
            $value = $this->cutExclusionSuffix($value);
        } else {
            $operator = $this->getPositiveOperator();
        }

        $value = $this->wrapValue($value);

        if ($this->isRelationshipFilter($attr_name)) {
            return $this->relationFilter($attr_name, $operator, $value);
        }

        $this->query->where($attr_name, $operator, $value);

        return $this;
    }

    /**
     * @param string $attr_name
     * @param string $operator
     *
     * @param string $value
     *
     * @return AbstractFilter
     */
    protected function relationFilter(string $attr_name, string $operator, string $value): self
    {
        $attr_array = explode(config('filters.relationship_separator'), $attr_name);
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
     * @return bool
     */
    protected function isRelationshipFilter(string $attr_name)
    {
        return count(explode(config('filters.relationship_separator'), $attr_name)) === 2;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function isExclusionModeOn(string $value): bool
    {
        $exclusion_suffix = config('filters.exclusion_suffix');
        $exclusion_suffix = str_replace('|', '\|', $exclusion_suffix);
        $regex = "/^.*($exclusion_suffix)+$/";
        return (bool) preg_match($regex, $value);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function cutExclusionSuffix(string $value): string
    {
        return str_replace(config('filters.exclusion_suffix'), '', $value);
    }

    abstract protected function getPositiveOperator(): string;
    abstract protected function getNegativeOperator(): string;
    abstract protected function wrapValue(string $value): string;
}
