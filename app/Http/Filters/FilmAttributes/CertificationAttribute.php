<?php

namespace App\Http\Filters\FilmAttributes;

use App\Http\Resources\CertificationResource;
use App\Models\Certification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CertificationAttribute extends AbstractAttribute
{

    protected function initAttribute(): void
    {
        $this->relation = 'certification';
        $this->attribute = 'name';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return $builder->whereHas($this->relation, function ($query) use ($value) {
            $query->whereIn($query->from.'.'.'id', $value);
        });
    }

    public static function getOptions(): AnonymousResourceCollection|array
    {
        return CertificationResource::collection(Certification::all());
    }
}
