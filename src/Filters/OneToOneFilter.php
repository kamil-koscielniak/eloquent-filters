<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

class OneToOneFilter extends AbstractFilter
{
    protected function getPositiveOperator(): string
    {
        return '=';
    }

    protected function getNegativeOperator(): string
    {
        return '!=';
    }

    protected function wrapValue(string $value): string
    {
        return $value;
    }
}
