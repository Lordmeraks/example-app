<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

abstract class AbstractAttribute implements FilterAttributeInterface
{
    protected string|null $relation;
    protected string|array $attribute;
    protected AbstractFilterService $filterService;

    public function __construct(AbstractFilterService $filterService)
    {
        $this->filterService = $filterService;
        $this->initAttribute();
    }

    abstract protected function initAttribute(): void;

    public function applySimple(Builder $builder, $value): Builder
    {
        if (empty($this->relation)) {
            return $builder->orWhere($this->attribute, 'like', "%$value%");
        } else {
            return $builder->orWhereHas($this->relation, function ($query) use ($value) {
                $query->where($query->from.'.'.$this->attribute, 'like', "%$value%");
            });
        }
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        if (empty($this->relation)) {
            return $builder->where($this->attribute, 'like', "%$value%");
        } else {
            return $builder->whereHas($this->relation, function ($query) use ($value) {
                $query->where($query->from.'.'.$this->attribute, 'like', "%$value%");
            });
        }
    }

    public static function getOptions(): AnonymousResourceCollection|array
    {
        return [];
    }
}
