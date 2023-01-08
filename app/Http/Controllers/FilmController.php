<?php

namespace App\Http\Controllers;

use App\Http\Filters\FilmAttributes\BudgetAttribute;
use App\Http\Filters\FilmAttributes\CertificationAttribute;
use App\Http\Filters\FilmAttributes\GenreAttribute;
use App\Http\Filters\FilmAttributes\LanguageAttribute;
use App\Http\Filters\FilmAttributes\RateAttribute;
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

    public function filters()
    {
        return response()->json([
            'title' => [
                'type' => 'text',
                'options' => []
            ],
            'writer' => [
                'type' => 'text',
                'options' => []
            ],
            'director' => [
                'type' => 'text',
                'options' => []
            ],
            'cast' => [
                'type' => 'text',
                'options' => []
            ],
            'budget' => [
                'type' => 'select',
                'options' => BudgetAttribute::getOptions()
            ],
            'certification' => [
                'type' => 'multiple',
                'options' => CertificationAttribute::getOptions()
            ],
            'genre' => [
                'type' => 'multiple',
                'options' => GenreAttribute::getOptions()
            ],
            'language' => [
                'type' => 'select',
                'options' => LanguageAttribute::getOptions()
            ],
            'rate' => [
                'type' => 'select',
                'options' => RateAttribute::getOptions()
            ],
            'year' => [
                'type' => 'number',
                'options' => []
            ],
        ]);
    }
}
