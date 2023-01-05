<?php

namespace App\Http\Controllers;

use App\Http\Filters\FilmFilter;
use App\Http\Resources\FilmCollection;
use App\Models\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return FilmCollection
     */
    public function index(FilmFilter $filmFilter)
    {
        $queryFilms = Film::getQueryForFilters();
        $queryFilms = $filmFilter->applySimpleSearch($queryFilms);
        $queryFilms = $filmFilter->applyFilters($queryFilms);
        $queryFilms = $queryFilms->orderBy('title');
        $films = $queryFilms->paginate(20);

        return new FilmCollection($films);
    }
}
