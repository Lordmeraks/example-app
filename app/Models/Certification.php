<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certification';

    protected $fillable = [
        'name',
    ];

    public function films(): HasMany
    {
        return $this->hasMany(Film::class, 'certification_id');
    }
}
