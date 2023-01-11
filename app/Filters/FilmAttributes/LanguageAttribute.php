<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LanguageAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'originalLanguage';
        $this->attribute = 'name';
    }

    public function applyFilter(Builder $builder, $value): Builder
    {
        return $builder->where('original_language_id', $value);
    }

    public static function getOptions(): AnonymousResourceCollection|array
    {
        return LanguageResource::collection(Language::all());
    }
}
