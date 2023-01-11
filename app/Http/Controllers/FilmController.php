<?php

namespace App\Http\Controllers;

use App\Filters\FilmAttributes\BudgetAttribute;
use App\Filters\FilmAttributes\CertificationAttribute;
use App\Filters\FilmAttributes\GenreAttribute;
use App\Filters\FilmAttributes\LanguageAttribute;
use App\Filters\FilmAttributes\RateAttribute;
use App\Filters\FilmFilter;
use App\Http\Resources\FilmCollection;
use App\Models\Film;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return FilmCollection
     */
    public function index(FilmFilter $filmFilter): ResourceCollection
    {
        $films = $filmFilter
            ->applyFilters(Film::getQueryForFilters())
            ->orderBy('title')
            ->paginate(20);

        return new FilmCollection($films);
    }

    public function filters(): JsonResponse
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
