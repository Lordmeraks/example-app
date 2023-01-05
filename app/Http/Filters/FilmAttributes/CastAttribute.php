<?php

namespace App\Http\Filters\FilmAttributes;

class CastAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'cast';
        $this->attribute = 'full_name';
    }
}
