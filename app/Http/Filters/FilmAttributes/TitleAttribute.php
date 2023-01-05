<?php

namespace App\Http\Filters\FilmAttributes;

class TitleAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->attribute = 'title';
    }
}
