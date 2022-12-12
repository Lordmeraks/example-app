<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullName',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'person';

    public function directorInFilms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_director', 'person_id', 'film_id');
    }

    public function writerInFilms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_writer', 'person_id', 'film_id');
    }

    public function castInFilms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_cast', 'person_id', 'film_id');
    }
}
