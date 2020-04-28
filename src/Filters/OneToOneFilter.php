<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

use KamilKoscielniak\EloquentFilters\Contracts\IFilter;

class OneToOneFilter extends AbstractFilter
{
    /**
     * @param string $attr_name
     *
     * @return IFilter
     */
    public function filter(string $attr_name): IFilter
    {
        if ($this->request->input($attr_name) === null) {
            return $this;
        }

        $value = $this->request->input($attr_name);
        $operator = $this->isExcludeOptionOn($value) ? '!=' : '=';

        if ($this->isRelationshipFilter($attr_name)) {
            return $this->relationFilter($attr_name, $operator, $value);
        }

        $this->query->where($attr_name, $operator, $value);

        return $this;
    }
}
