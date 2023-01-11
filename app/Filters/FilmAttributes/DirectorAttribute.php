<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;

class DirectorAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'directors';
        $this->attribute = 'full_name';
    }
}
