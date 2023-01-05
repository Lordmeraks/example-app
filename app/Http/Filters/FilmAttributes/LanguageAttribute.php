<?php

namespace App\Http\Filters\FilmAttributes;

use Illuminate\Database\Eloquent\Builder;

class LanguageAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'originalLanguage';
        $this->attribute = 'name';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return $builder->where('original_language_id', $value);
    }
}
