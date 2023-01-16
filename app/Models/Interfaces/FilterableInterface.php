<?php

namespace App\Models\Interfaces;


use Illuminate\Database\Eloquent\Builder;

interface FilterableInterface
{
    public static function getQueryForFilters(): Builder;
}
