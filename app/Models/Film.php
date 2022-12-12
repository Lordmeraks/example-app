<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    use HasFactory;

    protected $table = 'film';

    protected $fillable = [
        'budget',
        'homepage',
        'overview',
        'popularity',
        'posterPath',
        'releaseDate',
        'revenue',
        'runtime',
        'tagline',
        'title',
        'voteAverage',
        'voteCount',
        'similar',
        'trailerYt',
    ];

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_director', 'film_id', 'person_id');
    }

    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_writer', 'film_id', 'person_id');
    }

    public function cast(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_cast', 'film_id', 'person_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'film_genre', 'film_id', 'genre_id');
    }

    public function originalLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class, 'certification_id');
    }
}
