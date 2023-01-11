<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;
use Illuminate\Database\Eloquent\Builder;

class YearAttribute extends AbstractAttribute
{

    protected function initAttribute(): void
    {
        $this->attribute = 'release_date';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return $builder->whereYear($this->attribute, $value);
    }
}
