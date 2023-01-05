<?php

namespace App\Http\Filters\FilmAttributes;

use App\Http\Filters\FilterAttributeInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractAttribute implements FilterAttributeInterface
{
    protected string|null $relation;
    protected string $attribute;

    public function __construct()
    {
        $this->initAttribute();
    }

    abstract protected function initAttribute(): void;

    public function applySimple(Builder $builder, $value): Builder
    {
        if (empty($this->relation)) {
            return $builder->orWhere($this->attribute, 'like', "%$value%");
        } else {
            return $builder->orWhereHas($this->relation, function ($query) use ($value) {
                $query->where($this->attribute, 'like', "%$value%");
            });
        }
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        if (empty($this->relation)) {
            return $builder->where($this->attribute, 'like', "%$value%");
        } else {
            return $builder->whereHas($this->relation, function ($query) use ($value) {
                $query->where($this->attribute, 'like', "%$value%");
            });
        }
    }
}
