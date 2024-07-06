<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'courseCode',
        'courseDuration',
        'prereqCredits',
        'prereqMajorCredits',
        'courseName',
        'coursePrereqs',
        'concentration',
        'requiredByMajor',
    ];

    protected function casts(): array
    {
        return [
            'coursePrereqs' => 'array',
            'concentration' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
