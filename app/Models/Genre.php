<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Genre extends Model
{
    use AsSource, Filterable;

    protected $table = 'genre';

    protected $fillable = [
        'name',
    ];

    protected array $allowedFilters = [
        'id',
        'name',
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'name',
        'updated_at',
        'created_at',
    ];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_genre', 'genre_id', 'film_id');
    }
}
