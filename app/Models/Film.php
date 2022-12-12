<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'film';

    public function directors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_director', 'film_id', 'person_id');
    }

    public function writers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_writer', 'film_id', 'person_id');
    }

    public function cast(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'film_cast', 'film_id', 'person_id');
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'film_genre', 'film_id', 'genre_id');
    }

    public function originalLanguage(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    public function certification(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Certification::class, 'certification_id');
    }
}
