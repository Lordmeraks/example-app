<?php

namespace App\Filters;

use App\Http\Requests\FilmRequest;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilterService
{
    /**
     * @var array|string[]
     */
    protected array $filters;
    protected string $filterDir;

    public function __construct(FilmRequest $request)
    {
        $this->filters = $request->getFilters();
        $this->setDirectory();
    }

    abstract protected function setDirectory(): void;

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
        $className = $this->filterDir . ucfirst(trim($attribute)) . "Attribute";

        try {
            $filterAttribute = new $className($this);

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
