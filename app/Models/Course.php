<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'duration',
        'prereqCreditCount',
        'prereqCreditCountMajor',
        'name',
        'prereqs',
        'concentration',
        'isisRequiredByMajor',
        'minimumGrade',
    ];

    protected function casts(): array
    {
        return [
            'prereqs' => 'array',
            'concentration' => 'array',
        ];
    }
}
