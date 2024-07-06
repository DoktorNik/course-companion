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
        'coursePrereqCredits',
        'coursesMajorPrereqCredits',
        'courseName',
        'coursePrereqs',
        'elective',
        'requiredByMajor',
    ];

    protected function casts(): array
    {
        return [
            'coursePrereqs' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
