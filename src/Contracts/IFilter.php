<?php

namespace KamilKoscielniak\EloquentFilters\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface IFilter
{
    public function __construct(Builder $query, Request $request);

    public function filter(string $attr_name): self;
}
