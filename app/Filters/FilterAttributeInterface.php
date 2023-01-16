<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterAttributeInterface
{
    public function applySimple(Builder $builder, $value): Builder;
    public function applyFilter(Builder $builder, $value): Builder;
}
