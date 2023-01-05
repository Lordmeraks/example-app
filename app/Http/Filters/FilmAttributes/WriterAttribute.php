<?php

namespace App\Http\Filters\FilmAttributes;

class WriterAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'writers';
        $this->attribute = 'full_name';
    }
}
