<?php

namespace App\Filters\FilmAttributes;

use App\Filters\AbstractAttribute;

class WriterAttribute extends AbstractAttribute
{
    protected function initAttribute(): void
    {
        $this->relation = 'writers';
        $this->attribute = 'full_name';
    }
}
