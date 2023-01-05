<?php

namespace App\Models;

use App\Models\Interfaces\FilterableInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use LaravelIdea\Helper\App\Models\_IH_Film_QB;

class Film extends Model implements FilterableInterface
{
    use HasFactory;

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

    public static function getWithFilters($filters = [], $search = []): _IH_Film_QB|Builder
    {
        $query = self::query()
            ->with('genres')
            ->with('cast')
            ->with('directors')
            ->with('writers')
            ->with('originalLanguage')
            ->with('certification');
        foreach ($search as $value) {
            $query->where(function ($query) use ($value) {
                $query
                    ->orWhere('title', 'like', "%$value%")
                    ->orWhereHas('originalLanguage', function ($query) use ($value) {
                        $query->where('name', 'like', "%$value%");
                    })
                    ->orWhereHas('genres', function ($query) use ($value) {
                        $query->where('name', 'like', "%$value%");
                    })
                    ->orWhereHas('cast', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    })
                    ->orWhereHas('directors', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    })
                    ->orWhereHas('writers', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    });
            });
        }
        foreach ($filters as $filter => $value) {
            switch ($filter) {
                case 'title':
                {
                    $query->where('title', 'like', "%$value%");
                    break;
                }
                case 'language':
                {
                    $query->whereHas('originalLanguage', function ($query) use ($value) {
                        $query->where('name', 'like', "%$value%");
                    });
                    break;
                }
                case 'genre':
                {
                    $query->whereHas('genres', function ($query) use ($value) {
                        $query->where('name', 'like', "%$value%");
                    });
                    break;
                }
                case 'cast':
                {
                    $query->whereHas('cast', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    });
                    break;
                }
                case 'director':
                {
                    $query->whereHas('directors', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    });
                    break;
                }
                case 'writer':
                {
                    $query->whereHas('writers', function ($query) use ($value) {
                        $query->where('full_name', 'like', "%$value%");
                    });
                    break;
                }
            }
        }
        return $query->orderBy('title', 'asc');
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
