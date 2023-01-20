<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\GenreFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class FilmFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [GenreFilter::class];
    }
}
