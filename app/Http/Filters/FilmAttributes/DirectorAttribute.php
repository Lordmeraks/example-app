<?php

namespace App\Http\Filters\FilmAttributes;

class DirectorAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'directors';
        $this->attribute = 'full_name';
    }
}
