<?php

namespace App\Http\Filters;

use App\Models\Film;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilmFilter
{
    /**
     * @var array|string[]
     */
    private array $searchArray;
    private array $filters;

    public function __construct(Request $request)
    {
        $filters = $request->get('filters');
        $search = $request->get('search');
        $this->searchArray = !empty($search)?explode(' ', $search): [];
        $this->filters = is_array($filters) ? $filters : [];
    }

    public function applySimpleSearch(Builder $builder): Builder
    {
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

    public function getFilterAttribute(string $attribute): FilterAttributeInterface|bool
    {
        $className = "\App\Http\Filters\FilmAttributes\\" . ucfirst(trim($attribute)) . "Attribute:class";
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
