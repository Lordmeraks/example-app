<?php

namespace App\Filters;

use App\Http\Requests\FilmRequest;
use Illuminate\Database\Eloquent\Builder;

class FilmFilter extends AbstractFilterService
{
    protected function setDirectory(): void
    {
        $this->filterDir = "\App\Filters\FilmAttributes\\";
    }
}
