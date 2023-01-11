<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;
use App\Filters\FilmFilter;
use Illuminate\Database\Eloquent\Builder;

class SearchAttribute extends AbstractAttribute
{

    protected function initAttribute(): void
    {
        $this->attribute = [
            'title',
            'language',
            'genre',
            'cast',
            'director',
            'writer'
        ];
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        $searchArray = !empty($value) ? explode(' ', $value) : [];

        return $builder->orWhere(function ($query) use ($searchArray) {

            foreach ($searchArray as $value) {
                $query->orWhere(function ($query) use ($value) {

                    foreach ($this->attribute as $attribute) {
                        $filterAttribute = $this->filterService->getFilterAttribute($attribute);

                        if (!$filterAttribute) {
                            continue;
                        }

                        $filterAttribute->applySimple($query, $value);
                    }
                });
            }
        });
    }
}
