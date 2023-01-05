<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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


    public function __construct(Request $request)
    {
        $filters = $request->get('filters');
        $search = $request->get('search');
        $this->searchArray = !empty($search) ? explode(' ', $search) : [];
        $this->filters = is_array($filters) ? $filters : [];
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