<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;
use Illuminate\Database\Eloquent\Builder;

class BudgetAttribute extends AbstractAttribute
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
        $this->attribute = 'budget';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return match ($value) {
            1 => $builder->where(function ($query) {
                $query->where($this->attribute, '<=', 100000)->orWhereNull($this->attribute);
            }),
            2 => $builder->whereBetween($this->attribute, [100000, 100000000]),
            3 => $builder->where($this->attribute, '>=', 100000000),
        };
    }

    public static function getOptions(): array
    {
        return self::SELECT_PARAMS;
    }
}
