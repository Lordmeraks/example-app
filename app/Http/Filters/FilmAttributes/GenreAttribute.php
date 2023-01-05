<?php

namespace App\Http\Filters\FilmAttributes;

use Illuminate\Database\Eloquent\Builder;

class GenreAttribute implements \App\Http\Filters\FilterAttributeInterface
{

    public function applySimple(Builder $builder, $value): Builder
    {
        // TODO: Implement applySimple() method.
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        // TODO: Implement applyFilter() method.
    }
}
