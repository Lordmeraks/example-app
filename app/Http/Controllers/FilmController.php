<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmCollection;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return FilmCollection
     */
    public function index(Request $request)
    {
        $filters = $request->get('filters');
        $filters = is_array($filters) ? $filters : [];
        $queryFilms = Film::getWithFilters($filters);
        $films = $queryFilms->paginate(20);

        return new FilmCollection($films);
    }
}
