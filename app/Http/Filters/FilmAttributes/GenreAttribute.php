<?php

namespace App\Http\Filters\FilmAttributes;

use Illuminate\Database\Eloquent\Builder;

class GenreAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'genres';
        $this->attribute = 'name';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return $builder->whereHas($this->relation, function ($query) use ($value) {
            $query->whereIn('id', $value);
        });
    }
}
