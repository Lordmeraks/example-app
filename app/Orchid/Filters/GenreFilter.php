<?php

namespace App\Orchid\Filters;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class GenreFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Genres';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['genre'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereHas('genres', function ($query) {
            $query->whereIn($query->from . '.' . 'id', $this->request->get('genre'));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('genre')
                ->fromModel(Genre::class, 'name')
                ->multiple()
                ->empty('No select')
                ->title('Genres')
                ->value($this->request->get('genre'))
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() .
            ': ' . Genre::whereIn('id', $this->request->get('genre'))
                ->implode('name', ', ');
    }
}
