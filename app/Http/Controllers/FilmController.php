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
        $queryFilms = Film::query()
            ->with('genres')
            ->with('cast')
            ->with('directors')
            ->with('writers')
            ->with('originalLanguage')
            ->with('certification')
            ->orderBy('title', 'asc');
        $films = $queryFilms->paginate(20);

        return new FilmCollection($films);
    }
}
