<?php

namespace App\Http\Filters;

use App\Http\Requests\FilmRequest;
use Illuminate\Database\Eloquent\Builder;

class FilmFilter
{
    /**
     * @var array|string[]
     */
    protected array $searchArray;
    protected array $filters;

    const SIMPLE_ATTRIBUTES = [
        'title',
        'language',
        'genre',
        'cast',
        'director',
        'writer'
    ];

    public function __construct(FilmRequest $request)
    {
        $this->searchArray = $request->getSearch();
        $this->filters = $request->getFilters();
    }

    public function applySimpleSearch(Builder $builder): Builder
    {
        foreach ($this->searchArray as $value) {
            $builder->where(function ($query) use ($value) {
                $this->useSimpleAttributes($query, $value);
            });
        }
        return $builder;
    }

    protected function useSimpleAttributes(Builder $builder, $value): Builder
    {
        foreach (self::SIMPLE_ATTRIBUTES as $attribute) {
            $filterAttribute = $this->getFilterAttribute($attribute);
            if (!$filterAttribute) {
                continue;
            }
            $builder = $filterAttribute->applySimple($builder, $value);
        }
        return $builder;
    }

    public function applyFilters(Builder $builder): Builder
    {
        foreach ($this->filters as $attribute => $value) {
            $filterAttribute = $this->getFilterAttribute($attribute);
            if (!$filterAttribute) {
                continue;
            }
            $builder = $filterAttribute->applyFilter($builder, $value);
        }
        return $builder;
    }

    protected function getFilterAttribute(string $attribute): FilterAttributeInterface|bool
    {
        $className = "\App\Http\Filters\FilmAttributes\\" . ucfirst(trim($attribute)) . "Attribute";
        try {
            $filterAttribute = new $className();
            if ($filterAttribute instanceof FilterAttributeInterface) {
                return $filterAttribute;
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }
}
