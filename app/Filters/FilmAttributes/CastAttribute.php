<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;

class CastAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'cast';
        $this->attribute = 'full_name';
    }
}
