<?php

namespace App\Models;

use App\Models\Interfaces\FilterableInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class Film extends Model implements FilterableInterface
{
    use AsSource, Filterable;

    protected $table = 'film';

    protected $fillable = [
        'budget',
        'homepage',
        'overview',
        'popularity',
        'poster_path',
        'release_date',
        'revenue',
        'runtime',
        'tagline',
        'title',
        'vote_average',
        'vote_count',
        'similar',
        'trailer_yt',
        'external_ids',
    ];

    protected array $allowedFilters = [
        'id'         => Where::class,
        'title'      => Like::class,
        'updated_at' => Like::class,
        'created_at' => Like::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected array $allowedSorts = [
        'id',
        'title',
        'budget',
        'vote_average',
        'updated_at',
        'created_at',
    ];

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'film_director',
            'film_id',
            'person_id'
        );
    }

    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'film_writer',
            'film_id',
            'person_id'
        );
    }

    public function cast(): BelongsToMany
    {
        return $this->belongsToMany(
            Person::class,
            'film_cast',
            'film_id',
            'person_id'
        );
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'film_genre',
            'film_id',
            'genre_id'
        );
    }

    public function originalLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'original_language_id');
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class, 'certification_id');
    }

    public static function getQueryForFilters(): Builder
    {
        return self::query()
            ->with('genres')
            ->with('cast')
            ->with('directors')
            ->with('writers')
            ->with('originalLanguage')
            ->with('certification');
    }
}
