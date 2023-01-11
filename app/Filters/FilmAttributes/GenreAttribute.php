<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
            $query->whereIn($query->from.'.'.'id', $value);
        });
    }

    public static function getOptions(): AnonymousResourceCollection|array
    {
        return GenreResource::collection(Genre::all());
    }
}
