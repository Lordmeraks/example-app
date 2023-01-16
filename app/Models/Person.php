<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'full_name',
    ];

    public function directorInFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_director', 'person_id', 'film_id');
    }

    public function writerInFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_writer', 'person_id', 'film_id');
    }

    public function castInFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_cast', 'person_id', 'film_id');
    }
}
