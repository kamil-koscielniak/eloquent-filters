<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

use Illuminate\Database\Eloquent\Builder;

class RangeFilter extends AbstractFilter
{

    protected ?string $relation_name = null;
    protected ?string $relation_attr_name = null;

    /**
     * @param string $attr_name
     * @return RangeFilter
     */
    public function filter(string $attr_name): RangeFilter
    {
        $value = $this->request->input($attr_name);
        $value_arr = explode(config('filters.range_separator'), $value);

        if (count($value_arr) !== 2) {
            return $this;
        }

        if ($this->isRelationshipFilter($attr_name)) {
            $this->parseRelation($attr_name);
        }

        $this->parseValue($attr_name, $value_arr[0], $this->getPositiveOperator());
        $this->parseValue($attr_name, $value_arr[1], $this->getNegativeOperator());

        return $this;
    }

    protected function getPositiveOperator(): string
    {
        return '>=';
    }

    protected function getNegativeOperator(): string
    {
        return '<=';
    }

    protected function wrapValue(string $value): string
    {
        return $value;
    }

    protected function parseValue(string $attr_name, $value, string $operator)
    {
        if ($this->isExclusionModeOn($value)) {
            $operator = str_replace('=', '', $operator);
            $value = $this->cutExclusionSuffix($value);
        }

        if (! is_numeric($value)) {
            return;
        }

        if (! is_null($this->relation_name)) {
            $this->query->whereHas($this->relation_name, fn (Builder $q) => $q->where($this->relation_attr_name, $operator, $value));
        } else {
            $this->query->where($attr_name, $operator, $value);
        }
    }

    protected function parseRelation(string $attr_name): void
    {
        $attr_array = explode(config('filters.relationship_separator'), $attr_name);
        $this->relation_name = $attr_array[0];
        $this->relation_attr_name = $attr_array[1];
    }
}
