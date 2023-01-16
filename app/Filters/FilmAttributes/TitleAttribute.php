<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;

class TitleAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->attribute = 'title';
    }
}
