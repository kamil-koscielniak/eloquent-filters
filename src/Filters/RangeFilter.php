<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

use KamilKoscielniak\EloquentFilters\Contracts\IFilter;

class RangeFilter extends AbstractFilter
{
    /**
     * @param string $attr_name
     * @return IFilter
     */
    public function filter(string $attr_name): IFilter
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
                $this->query->where($attr_name, '>', $from);
            }

            if ($to) {
                $this->query->where($attr_name, '<', $to);
            }
        }

        return $this;
    }
}
