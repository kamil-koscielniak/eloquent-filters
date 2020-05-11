<?php

namespace KamilKoscielniak\EloquentFilters\Filters;

class IncludeFilter extends AbstractFilter
{
    protected function getPositiveOperator(): string
    {
        return 'like';
    }

    protected function getNegativeOperator(): string
    {
        return 'not like';
    }

    protected function wrapValue(string $value): string
    {
        return "%$value%";
    }
}
