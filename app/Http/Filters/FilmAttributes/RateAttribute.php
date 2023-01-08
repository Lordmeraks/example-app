<?php

namespace App\Http\Filters\FilmAttributes;

use Illuminate\Database\Eloquent\Builder;

class RateAttribute extends AbstractAttribute
{
    const SELECT_PARAMS = [
        [
            'value' => 1,
            'label' => 'low or unknown'
        ],
        [
            'value' => 2,
            'label' => 'average'
        ],
        [
            'value' => 3,
            'label' => 'high'
        ]
    ];
    protected function initAttribute(): void
    {
        $this->attribute = 'vote_average';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return match ($value) {
            1 => $builder->where($this->attribute, '<=', 5.0)->orWhereNull($this->attribute),
            2 => $builder->whereBetween($this->attribute, [5.0, 8.0]),
            3 => $builder->where($this->attribute, '>=', 8.0),
        };
    }

    public static function getOptions(): array
    {
        return self::SELECT_PARAMS;
    }
}
