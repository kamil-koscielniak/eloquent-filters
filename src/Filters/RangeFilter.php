<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

class RangeFilter extends AbstractFilter
{
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

        $from = $value_arr[0];
        $to = $value_arr[1];

        if ($from !== null || $to !== null) {

//            if ($this->isRelationshipFilter($attr_name)) {
//                return $this->relationFilter($attr_name, $operator, $value);
//            }

            if ($from) {
                $this->query->where($attr_name, $this->getPositiveOperator(), $from);
            }

            if ($to) {
                $this->query->where($attr_name, $this->getNegativeOperator(), $to);
            }
        }

        return $this;
    }

    protected function getPositiveOperator(): string
    {
        return '>';
    }

    protected function getNegativeOperator(): string
    {
        return '<';
    }

    protected function wrapValue(string $value): string
    {
        return $value;
    }
}
